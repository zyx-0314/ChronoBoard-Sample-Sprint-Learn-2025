# Deployment Process Guide

## Overview

This document outlines the deployment process for ChronoBoard. We use Docker and GitHub Actions for automated, consistent deployments.

## Deployment Principles

### Core Values

1. **Reproducibility**: Same process every time
2. **Automation**: Minimize manual steps
3. **Safety**: Multiple checks before production
4. **Rollback**: Easy to revert if needed
5. **Monitoring**: Know when something goes wrong

## Deployment Environments

### Development

**Purpose**: Local development and testing

**Configuration**:
- Local Docker containers
- Debug mode enabled
- Verbose logging
- Test database

**Access**: All developers

**Deployment**: Manual, on-demand

### Staging

**Purpose**: Pre-production testing and validation

**Configuration**:
- Mirrors production setup
- Debug mode enabled
- Full logging
- Separate database

**Access**: Development team

**Deployment**: Automatic on merge to `staging` branch

### Production

**Purpose**: Live application serving real users

**Configuration**:
- Optimized performance
- Debug mode disabled
- Error logging only
- Production database

**Access**: Limited to administrators

**Deployment**: Automatic on merge to `main` branch

## Deployment Workflow

### Standard Deployment Process

```
1. Development
   ├─ Write code locally
   ├─ Test with Docker
   └─ Commit to feature branch

2. Code Review
   ├─ Create pull request
   ├─ Automated tests run
   ├─ Code review
   └─ Approval required

3. Merge to Main
   ├─ PR merged
   ├─ Automated tests run
   ├─ Build Docker image
   └─ Deploy to staging (optional)

4. Production Deployment
   ├─ Manual approval (if required)
   ├─ Deploy to production
   ├─ Health checks
   └─ Monitor for issues

5. Post-Deployment
   ├─ Verify functionality
   ├─ Monitor logs
   ├─ Check metrics
   └─ Rollback if needed
```

## Using Docker for Deployment

### Docker Compose Production

Create `docker-compose.prod.yml`:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
      target: production
    container_name: chronoboard-app-prod
    restart: always
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
    volumes:
      - ./storage:/var/www/storage
    networks:
      - chronoboard-network
    depends_on:
      - database

  database:
    image: mysql:8.0
    container_name: chronoboard-db-prod
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - prod-db-data:/var/lib/mysql
    networks:
      - chronoboard-network

  nginx:
    image: nginx:alpine
    container_name: chronoboard-nginx-prod
    restart: always
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./nginx/prod.conf:/etc/nginx/nginx.conf
      - ./ssl:/etc/nginx/ssl
    networks:
      - chronoboard-network
    depends_on:
      - app

networks:
  chronoboard-network:
    driver: bridge

volumes:
  prod-db-data:
    driver: local
```

### Multi-Stage Dockerfile

Create optimized production image:

```dockerfile
# Build stage
FROM php:8.1-fpm as builder

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Production stage
FROM php:8.1-fpm as production

WORKDIR /var/www

# Install only runtime dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy built application from builder
COPY --from=builder /var/www /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
```

## GitHub Actions CI/CD

### Automated Testing and Deployment

Create `.github/workflows/deploy.yml`:

```yaml
name: Deploy

on:
  push:
    branches:
      - main
      - staging
  pull_request:
    branches:
      - main

jobs:
  test:
    name: Run Tests
    runs-on: ubuntu-latest
    
    steps:
      - name: Checkout code
        uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          extensions: mbstring, xml, pdo_mysql
      
      - name: Install dependencies
        run: composer install --prefer-dist --no-progress
      
      - name: Run tests
        run: composer test
      
      - name: Run linter
        run: composer lint
  
  build:
    name: Build Docker Image
    needs: test
    runs-on: ubuntu-latest
    if: github.ref == 'refs/heads/main'
    
    steps:
      - name: Checkout code
        uses: actions/checkout@v3
      
      - name: Set up Docker Buildx
        uses: docker/setup-buildx-action@v2
      
      - name: Login to Container Registry
        uses: docker/login-action@v2
        with:
          registry: ghcr.io
          username: ${{ github.actor }}
          password: ${{ secrets.GITHUB_TOKEN }}
      
      - name: Build and push
        uses: docker/build-push-action@v4
        with:
          context: .
          push: true
          tags: ghcr.io/${{ github.repository }}:latest
          cache-from: type=gha
          cache-to: type=gha,mode=max
  
  deploy:
    name: Deploy to Production
    needs: build
    runs-on: ubuntu-latest
    if: github.ref == 'refs/heads/main'
    
    steps:
      - name: Deploy to server
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.PRODUCTION_HOST }}
          username: ${{ secrets.PRODUCTION_USER }}
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd /var/www/chronoboard
            docker-compose pull
            docker-compose up -d
            docker-compose exec -T app php artisan migrate --force
            docker-compose exec -T app php artisan cache:clear
```

## Deployment Commands

### Manual Deployment

```bash
# Pull latest changes
git pull origin main

# Build Docker images
docker-compose -f docker-compose.prod.yml build

# Stop current containers
docker-compose -f docker-compose.prod.yml down

# Start new containers
docker-compose -f docker-compose.prod.yml up -d

# Run migrations
docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Clear cache
docker-compose -f docker-compose.prod.yml exec app php artisan cache:clear

# Check status
docker-compose -f docker-compose.prod.yml ps
```

### Zero-Downtime Deployment

```bash
# Pull new images
docker-compose pull

# Scale up new instances
docker-compose up -d --scale app=2 --no-recreate

# Wait for health check
sleep 10

# Remove old instances
docker-compose up -d --scale app=1 --remove-orphans
```

## Pre-Deployment Checklist

Before deploying to production:

- [ ] All tests passing
- [ ] Code reviewed and approved
- [ ] No known bugs in changes
- [ ] Database migrations reviewed
- [ ] Environment variables updated
- [ ] Backup created
- [ ] Rollback plan ready
- [ ] Team notified
- [ ] Monitoring in place

## Post-Deployment Checklist

After deployment:

- [ ] Application is accessible
- [ ] Health checks passing
- [ ] No errors in logs
- [ ] Database migrations completed
- [ ] Cache cleared
- [ ] Background jobs running
- [ ] Performance metrics normal
- [ ] Users can perform key actions
- [ ] Team notified of completion

## Database Migrations

### Running Migrations

```bash
# Check migration status
docker-compose exec app php artisan migrate:status

# Run pending migrations
docker-compose exec app php artisan migrate --force

# Rollback last migration
docker-compose exec app php artisan migrate:rollback --step=1

# Reset database (DANGER - only in development)
docker-compose exec app php artisan migrate:fresh
```

### Migration Best Practices

✅ **Do**:
- Test migrations in staging first
- Make migrations reversible
- Back up database before major migrations
- Run migrations during low-traffic periods
- Keep migrations small and focused

❌ **Don't**:
- Run migrations without backup
- Make breaking changes without migration path
- Combine data and schema changes
- Skip testing migrations

## Rollback Process

### When to Rollback

Rollback immediately if:
- Critical bugs discovered
- Site is down or significantly degraded
- Data corruption detected
- Security vulnerability introduced

### How to Rollback

1. **Identify last good version**
   ```bash
   git log --oneline
   ```

2. **Revert to previous version**
   ```bash
   git revert <commit-hash>
   git push origin main
   ```

3. **Or use Docker tags**
   ```bash
   docker pull ghcr.io/repo/app:previous-tag
   docker-compose up -d
   ```

4. **Rollback database if needed**
   ```bash
   docker-compose exec app php artisan migrate:rollback
   ```

5. **Verify rollback**
   - Test critical functionality
   - Check logs
   - Monitor metrics

## Monitoring and Logging

### Health Checks

Create health check endpoint:

```php
// routes/api.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'timestamp' => now()->toISOString()
    ]);
});
```

### Log Monitoring

```bash
# View application logs
docker-compose logs -f app

# View last 100 lines
docker-compose logs --tail=100 app

# View error logs only
docker-compose logs app | grep ERROR
```

### Set Up Alerts

Monitor for:
- Application errors
- High response times
- Database connection failures
- Disk space issues
- Memory usage spikes

## Environment Variables

### Managing Secrets

Never commit secrets to repository:

```bash
# .env.example (commit this)
DB_HOST=database
DB_PORT=3306
DB_DATABASE=chronoboard
DB_USERNAME=user
DB_PASSWORD=<set-in-production>

# .env (never commit)
DB_PASSWORD=actual_secure_password
```

### Using GitHub Secrets

Store secrets in GitHub:
1. Go to repository settings
2. Secrets and variables → Actions
3. Add secret
4. Reference in workflows: `${{ secrets.SECRET_NAME }}`

## Security Considerations

### Before Deployment

- [ ] Dependencies updated
- [ ] Known vulnerabilities patched
- [ ] Security headers configured
- [ ] HTTPS enabled
- [ ] Secrets properly managed
- [ ] Access controls in place
- [ ] Input validation present
- [ ] SQL injection prevented

### SSL/TLS Configuration

```nginx
# nginx/prod.conf
server {
    listen 443 ssl http2;
    server_name chronoboard.example.com;
    
    ssl_certificate /etc/nginx/ssl/cert.pem;
    ssl_certificate_key /etc/nginx/ssl/key.pem;
    
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    
    location / {
        proxy_pass http://app:9000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

## Troubleshooting Deployments

### Common Issues

**Containers won't start**:
```bash
# Check logs
docker-compose logs

# Check configuration
docker-compose config

# Rebuild images
docker-compose build --no-cache
```

**Database connection failed**:
```bash
# Check database is running
docker-compose ps database

# Check environment variables
docker-compose exec app env | grep DB_

# Test connection
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

**Migrations failed**:
```bash
# Check migration status
docker-compose exec app php artisan migrate:status

# Rollback and retry
docker-compose exec app php artisan migrate:rollback
docker-compose exec app php artisan migrate --force
```

## Best Practices

### Deployment Safety

✅ **Do**:
- Deploy during low-traffic hours
- Test in staging first
- Have rollback plan ready
- Monitor after deployment
- Communicate with team
- Keep deployments small
- Automate where possible

❌ **Don't**:
- Deploy on Fridays
- Deploy without testing
- Deploy multiple changes at once
- Skip backups
- Ignore monitoring
- Deploy without team knowledge

### Continuous Improvement

- Review deployment process regularly
- Automate manual steps
- Document issues and solutions
- Learn from deployment problems
- Share knowledge with team

## Quick Reference

```bash
# Build and deploy
docker-compose -f docker-compose.prod.yml up -d --build

# View logs
docker-compose logs -f

# Run migrations
docker-compose exec app php artisan migrate --force

# Clear cache
docker-compose exec app php artisan cache:clear

# Check status
docker-compose ps

# Restart service
docker-compose restart app

# Stop all services
docker-compose down

# Stop and remove volumes
docker-compose down -v
```

## Related Documentation

- [Docker Setup Guide](../setup/docker-setup.md)
- [Development Workflow](../workflows/development-workflow.md)
- [Testing Strategy](../testing/testing-strategy.md)

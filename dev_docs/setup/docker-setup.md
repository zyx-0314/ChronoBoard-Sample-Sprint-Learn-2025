# Docker Setup Guide

## Overview

This guide covers setting up ChronoBoard using Docker for local development. Docker provides a consistent, reproducible development environment across all platforms.

## Why Docker?

✅ **Consistency**: Same environment for all developers
✅ **Isolation**: No conflicts with other projects
✅ **Reproducibility**: Easy to recreate exact environment
✅ **Portability**: Works on Windows, macOS, and Linux
✅ **Quick Setup**: No manual dependency installation

## Prerequisites

### 1. Install Docker Desktop

**Windows**:
- Download from [docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)
- Requires Windows 10/11 Pro, Enterprise, or Education
- Enable WSL 2 (Windows Subsystem for Linux)

**macOS**:
- Download from [docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)
- Requires macOS 10.15 or newer
- Install and start Docker Desktop

**Linux**:
```bash
# Ubuntu/Debian
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
newgrp docker

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### 2. Verify Installation

```bash
# Check Docker version
docker --version
# Expected: Docker version 20.x.x or higher

# Check Docker Compose version
docker-compose --version
# Expected: Docker Compose version 2.x.x or higher

# Test Docker installation
docker run hello-world
# Should download and run a test container
```

## Quick Start

### 1. Clone Repository

```bash
git clone https://github.com/zyx-0314/ChronoBoard-Sample-Sprint-Learn-2025.git
cd ChronoBoard-Sample-Sprint-Learn-2025
```

### 2. Start Docker Containers

```bash
# Build and start containers
docker-compose up -d

# View running containers
docker-compose ps

# View logs
docker-compose logs -f
```

### 3. Access Application

Open your browser and navigate to:
- **Application**: http://localhost:8000
- **Database**: localhost:3306 (use database client)

### 4. Stop Containers

```bash
# Stop containers
docker-compose down

# Stop and remove volumes (clean slate)
docker-compose down -v
```

## Docker Configuration

### Docker Compose File

Create `docker-compose.yml` in project root (if not exists):

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: chronoboard-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    ports:
      - "8000:80"
    networks:
      - chronoboard-network
    environment:
      - APP_ENV=development
      - APP_DEBUG=true
      - DB_HOST=database
      - DB_PORT=3306
      - DB_DATABASE=chronoboard
      - DB_USERNAME=chronoboard_user
      - DB_PASSWORD=chronoboard_password
    depends_on:
      - database

  database:
    image: mysql:8.0
    container_name: chronoboard-database
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: chronoboard
      MYSQL_USER: chronoboard_user
      MYSQL_PASSWORD: chronoboard_password
      MYSQL_ROOT_PASSWORD: root_password
    ports:
      - "3306:3306"
    volumes:
      - database-data:/var/lib/mysql
      - ./docker/mysql/my.cnf:/etc/mysql/my.cnf
    networks:
      - chronoboard-network

  cache:
    image: redis:7-alpine
    container_name: chronoboard-cache
    restart: unless-stopped
    ports:
      - "6379:6379"
    networks:
      - chronoboard-network

networks:
  chronoboard-network:
    driver: bridge

volumes:
  database-data:
    driver: local
```

### Dockerfile

Create `Dockerfile` in project root (if not exists):

```dockerfile
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose port
EXPOSE 80

# Start PHP-FPM
CMD ["php-fpm"]
```

## Common Docker Commands

### Container Management

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# View running containers
docker-compose ps

# View all containers (including stopped)
docker ps -a
```

### Logs and Debugging

```bash
# View logs for all services
docker-compose logs

# Follow logs in real-time
docker-compose logs -f

# View logs for specific service
docker-compose logs app
docker-compose logs database

# View last 100 lines
docker-compose logs --tail=100
```

### Executing Commands

```bash
# Run command in container
docker-compose exec app php --version

# Open bash shell in container
docker-compose exec app bash

# Run Composer commands
docker-compose exec app composer install
docker-compose exec app composer update

# Run database migrations
docker-compose exec app php yii migrate

# Run tests
docker-compose exec app composer test
```

### Database Operations

```bash
# Access MySQL shell
docker-compose exec database mysql -u root -p

# Import database dump
docker-compose exec -T database mysql -u root -p chronoboard < backup.sql

# Export database dump
docker-compose exec database mysqldump -u root -p chronoboard > backup.sql

# View database logs
docker-compose logs database
```

### Volume Management

```bash
# List volumes
docker volume ls

# Remove all unused volumes
docker volume prune

# Remove specific volume
docker volume rm chronoboard_database-data

# Inspect volume
docker volume inspect chronoboard_database-data
```

### Image Management

```bash
# List images
docker images

# Remove unused images
docker image prune

# Rebuild images
docker-compose build

# Rebuild without cache
docker-compose build --no-cache

# Pull latest images
docker-compose pull
```

## Development Workflow with Docker

### Daily Workflow

1. **Start your day**
   ```bash
   # Start containers
   docker-compose up -d
   
   # Check status
   docker-compose ps
   ```

2. **Make code changes**
   - Edit files in your local directory
   - Changes are automatically synced to container

3. **Run commands**
   ```bash
   # Install new dependencies
   docker-compose exec app composer require package/name
   
   # Run tests
   docker-compose exec app composer test
   
   # Check logs
   docker-compose logs -f app
   ```

4. **End your day**
   ```bash
   # Stop containers (preserves data)
   docker-compose down
   ```

### Testing Workflow

```bash
# Run all tests
docker-compose exec app composer test

# Run specific test
docker-compose exec app vendor/bin/phpunit tests/YourTest.php

# Run tests with coverage
docker-compose exec app composer test -- --coverage-html coverage/
```

### Database Workflow

```bash
# Run migrations
docker-compose exec app php yii migrate

# Reset database
docker-compose exec app php yii migrate/fresh

# Seed database
docker-compose exec app php yii migrate/seed
```

## Troubleshooting

### Port Already in Use

```bash
# Find process using port
lsof -i :8000

# Kill process
kill -9 <PID>

# Or change port in docker-compose.yml
ports:
  - "8001:80"  # Changed from 8000
```

### Container Won't Start

```bash
# Check logs for errors
docker-compose logs app

# Rebuild container
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Check container status
docker-compose ps
```

### Permission Issues

```bash
# Fix permissions in container
docker-compose exec app chown -R www-data:www-data /var/www

# Or on host (macOS/Linux)
sudo chown -R $USER:$USER .
```

### Database Connection Failed

```bash
# Check database is running
docker-compose ps database

# Check database logs
docker-compose logs database

# Verify environment variables
docker-compose exec app env | grep DB_

# Test connection
docker-compose exec app php -r "new PDO('mysql:host=database;dbname=chronoboard', 'chronoboard_user', 'chronoboard_password');"
```

### Out of Disk Space

```bash
# Check disk usage
docker system df

# Clean up unused resources
docker system prune -a

# Remove specific items
docker container prune  # Remove stopped containers
docker image prune      # Remove unused images
docker volume prune     # Remove unused volumes
```

### Slow Performance

**Windows**:
- Store project files in WSL2 filesystem
- Increase Docker Desktop memory allocation

**macOS**:
- Increase Docker Desktop memory/CPU allocation
- Use `:cached` or `:delegated` volume mounts

```yaml
volumes:
  - ./:/var/www:cached  # Better performance on macOS
```

### Can't Connect to Database from Host

```bash
# Ensure port is mapped
# In docker-compose.yml:
ports:
  - "3306:3306"

# Connect using:
# Host: localhost
# Port: 3306
# User: chronoboard_user
# Password: chronoboard_password
```

## Best Practices

### Container Management

✅ **Use docker-compose for local development**
- Easier than managing individual containers
- Configuration in version control
- Consistent across team

✅ **Keep containers running**
- Start containers and leave them running
- Faster than starting/stopping frequently
- Only restart when needed

✅ **Use named volumes for data**
- Persist data between container restarts
- Easier to backup and restore

### Development Practices

✅ **Mount source code as volume**
- Edit files on host
- Changes reflected immediately
- No need to rebuild container

✅ **Use environment-specific configs**
- Different configs for dev/test/prod
- Use .env files
- Don't commit sensitive data

✅ **Keep images small**
- Use multi-stage builds
- Remove unnecessary files
- Minimize layers

### Performance Optimization

✅ **Use .dockerignore**
```
.git
.gitignore
node_modules
vendor
*.log
.env
.DS_Store
```

✅ **Leverage build cache**
- Order Dockerfile instructions properly
- Copy dependency files first
- Copy source code last

✅ **Allocate adequate resources**
- Give Docker Desktop enough memory (4GB+)
- Allocate multiple CPUs if available

## Docker Compose Commands Reference

```bash
# Start services
docker-compose up                    # Start in foreground
docker-compose up -d                 # Start in background (detached)
docker-compose up --build            # Rebuild images before starting

# Stop services
docker-compose stop                  # Stop containers (preserve state)
docker-compose down                  # Stop and remove containers
docker-compose down -v               # Also remove volumes

# Service management
docker-compose start                 # Start stopped services
docker-compose restart               # Restart services
docker-compose pause                 # Pause services
docker-compose unpause               # Unpause services

# Information
docker-compose ps                    # List containers
docker-compose logs                  # View logs
docker-compose top                   # Display running processes
docker-compose config                # Validate and view config

# Execution
docker-compose exec <service> <cmd>  # Run command in running container
docker-compose run <service> <cmd>   # Run one-off command
```

## Next Steps

Once Docker is set up:

1. **Verify everything works**
   - Access application in browser
   - Run tests
   - Check database connection

2. **Read other documentation**
   - [Development Workflow](../workflows/development-workflow.md)
   - [Testing Strategy](../testing/testing-strategy.md)
   - [Coding Standards](../../guidelines/coding-standards.md)

3. **Start developing**
   - Create feature branch
   - Make changes
   - Submit pull request

## Related Documentation

- [Environment Setup Guide](./environment-setup.md)
- [Codespaces Setup Guide](./codespaces-setup.md)
- [Deployment Guide](../deployment/deployment-process.md)

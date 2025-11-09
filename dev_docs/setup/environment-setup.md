# Environment Setup Guide

## Overview

This guide will help you set up your development environment for ChronoBoard. We support development using Docker and GitHub Codespaces for consistency and reproducibility.

## Prerequisites

Before starting, ensure you have:

- Git installed (2.x or higher)
- Text editor or IDE (VS Code recommended)
- Terminal/Command line access

**Choose one of the following environments**:

- **Option A**: Docker Desktop (for local development)
- **Option B**: GitHub Codespaces (for cloud development)

## Quick Start Options

### Option A: Docker Setup (Recommended for Local)

Best for developers who want local development with full control.

**Advantages**:

- Works offline
- Full control over environment
- Consistent across platforms
- Fast performance

[See detailed Docker setup guide](./docker-setup.md)

### Option B: Codespaces Setup

Best for quick start and consistency across team.

**Advantages**:

- No local setup needed
- Identical environment for all developers
- Access from anywhere
- Pre-configured tools

[See detailed Codespaces setup guide](./codespaces-setup.md)

## General Setup Steps

These steps apply regardless of which environment you choose:

### 1. Clone Repository

```bash
# Clone the repository
git clone https://github.com/zyx-0314/ChronoBoard-Sample-Sprint-Learn-2025.git

# Navigate to project directory
cd ChronoBoard-Sample-Sprint-Learn-2025
```

### 2. Configure Git

```bash
# Set your name and email
git config user.name "Your Full Name"
git config user.email "your.email@example.com"

# Set default branch name
git config init.defaultBranch main

# Enable helpful features
git config pull.rebase false
git config core.autocrlf input  # Use 'true' on Windows
```

### 3. Review Project Structure

Familiarize yourself with the project layout:

```
ChronoBoard-Sample-Sprint-Learn-2025/
├── dev_docs/          # Developer documentation
├── formats/           # Templates and format examples
├── guidelines/        # Coding standards and guidelines
├── src/               # Source code (if present)
├── tests/             # Test files (if present)
├── README.md          # Project overview
└── .gitignore         # Git ignore rules
```

### 4. Install Dependencies

The dependency installation process depends on your environment:

**Docker**: Dependencies are installed automatically in containers

**Codespaces**: Dependencies are installed automatically on startup

**Local (without Docker)**: Follow manual installation steps below

## Manual Local Setup (Without Docker)

Only use this if you're not using Docker or Codespaces.

### Install Required Software

1. **PHP** (7.4 or higher)

   ```bash
   # Ubuntu/Debian
   sudo apt-get update
   sudo apt-get install php php-cli php-mysql php-mbstring php-xml

   # macOS with Homebrew
   brew install php

   # Windows: Download from php.net
   ```

2. **Composer** (PHP dependency manager)

   ```bash
   # Download and install Composer
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   php composer-setup.php
   php -r "unlink('composer-setup.php');"
   sudo mv composer.phar /usr/local/bin/composer
   ```

3. **MySQL** (8.0 or higher)

   ```bash
   # Ubuntu/Debian
   sudo apt-get install mysql-server

   # macOS with Homebrew
   brew install mysql

   # Windows: Download from mysql.com
   ```

4. **Node.js** (if frontend tools needed)
   ```bash
   # Using nvm (recommended)
   curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
   nvm install --lts
   nvm use --lts
   ```

### Install Project Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies (if applicable)
npm install
```

### Configure Application

1. **Copy environment file**

   - Windows:
     Copy the `.env.example` and name it `.env`
   - Linux
     ```bash
     cp .env.example .env
     ```

2. **Edit .env file**

   - Windows
     Edit file and add the needed tokens
   - Linux
     ```bash
     # Edit with your preferred editor
     nano .env
     # or
     code .env
     ```

3. **Set database credentials**
   ```.env
   <!-- Example -->
   DB_HOST=localhost
   DB_NAME=chronoboard
   DB_USER=your_username
   DB_PASSWORD=your_password
   ```

### Initialize Web App

```bash
php init
```

### Initialize Database

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE chronoboard;"

# Run migrations (if applicable)
php yii migrate
```

## Verify Installation

### Check Environment

```bash
# Check PHP version
php --version

# Check Composer version
composer --version

# Check MySQL connection
mysql -u root -p -e "SELECT VERSION();"

# Check Git version
git --version
```

### Test Application

```bash
# Run tests (if available)
composer test

# Start development server (if applicable)
php -S localhost:8000
```

Visit `http://localhost:8000` in your browser to verify.

## Development Tools

### Recommended VS Code Extensions

- **PHP Intelephense**: PHP intellisense
- **GitLens**: Enhanced Git features
- **EditorConfig**: Consistent code formatting
- **Docker**: Docker file support
- **ESLint**: JavaScript linting (if applicable)

### Recommended Configuration

Create `.vscode/settings.json`:

```json
{
  "editor.formatOnSave": true,
  "editor.tabSize": 4,
  "files.insertFinalNewline": true,
  "files.trimTrailingWhitespace": true,
  "php.validate.executablePath": "/usr/bin/php",
  "[php]": {
    "editor.defaultFormatter": "bmewburn.vscode-intelephense-client"
  }
}
```

## Environment Variables

Key environment variables you may need to configure:

### Application Settings

```bash
# Environment mode
APP_ENV=development          # development, production, test
APP_DEBUG=true               # true for development, false for production

# Application URL
APP_URL=http://localhost:8000
```

### Database Settings

```bash
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=chronoboard
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Email Settings (if applicable)

```bash
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### Cache Settings (if applicable)

```bash
CACHE_DRIVER=file            # file, redis, memcached
SESSION_DRIVER=file          # file, cookie, database, redis
```

## Troubleshooting

### Common Issues

**Issue**: Composer dependencies fail to install

```bash
# Solution: Update Composer and try again
composer self-update
composer clear-cache
composer install
```

**Issue**: MySQL connection refused

```bash
# Solution: Check MySQL is running
sudo systemctl status mysql
sudo systemctl start mysql
```

**Issue**: Permission denied errors

```bash
# Solution: Fix file permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Issue**: Port already in use

```bash
# Solution: Find and kill process using port
lsof -i :8000
kill -9 <PID>

# Or use different port
php -S localhost:8001
```

### Getting Help

If you encounter issues:

1. Check documentation in `dev_docs/`
2. Search for similar issues in repository
3. Ask team members
4. Create an issue with:
   - What you were trying to do
   - What happened instead
   - Error messages
   - Your environment details

## Environment Health Check

Run this checklist to verify your setup:

- [ ] Git is installed and configured
- [ ] Repository cloned successfully
- [ ] Required software installed (PHP, Composer, MySQL)
- [ ] Dependencies installed without errors
- [ ] Environment variables configured
- [ ] Database created and accessible
- [ ] Application starts without errors
- [ ] Tests run successfully (if applicable)
- [ ] Can create new branch
- [ ] Can commit and push changes

## Next Steps

Once your environment is set up:

1. **Review documentation**

   - Read [Development Workflow](../workflows/development-workflow.md)
   - Understand [Branch Strategy](../workflows/branch-strategy.md)
   - Study [Coding Standards](../../guidelines/coding-standards.md)

2. **Explore the codebase**

   - Read existing code
   - Understand project structure
   - Review recent commits

3. **Start contributing**
   - Pick a small issue to start
   - Create a feature branch
   - Make your changes
   - Submit a pull request

## Best Practices

### Keep Environment Updated

```bash
# Update dependencies regularly
composer update
npm update

# Pull latest changes
git pull origin main

# Update Docker images
docker-compose pull
```

### Use Consistent Settings

- Follow EditorConfig settings
- Use project's code style
- Match team's tool versions

### Isolate Environments

- Use separate databases for dev/test/prod
- Don't mix dependencies from different projects
- Clean up old containers/images regularly

### Document Problems

- Note any setup issues encountered
- Suggest improvements to setup docs
- Share solutions with team

## Security Considerations

### Protect Sensitive Data

- Never commit `.env` file
- Don't share credentials
- Use strong passwords
- Rotate keys regularly

### Keep Software Updated

- Update dependencies for security patches
- Monitor vulnerability alerts
- Use supported versions

### Use Secure Connections

- Use HTTPS in production
- Enable SSL for database
- Secure API endpoints

## Related Documentation

- [Docker Setup Guide](./docker-setup.md)
- [Codespaces Setup Guide](./codespaces-setup.md)
- [Development Workflow](../workflows/development-workflow.md)
- [Testing Strategy](../testing/testing-strategy.md)

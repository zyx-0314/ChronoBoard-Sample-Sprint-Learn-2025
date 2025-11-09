# GitHub Codespaces Setup Guide

## Overview

GitHub Codespaces provides a complete, configurable development environment in the cloud. Start coding in seconds without any local setup.

## What is Codespaces?

Codespaces is a cloud-based development environment that provides:

✅ **Instant Setup**: Ready to code in seconds
✅ **Consistency**: Same environment for everyone
✅ **Accessibility**: Access from anywhere with internet
✅ **Pre-configured**: Tools and dependencies installed automatically
✅ **Powerful**: Cloud computing resources
✅ **Cost-effective**: Free tier available for open source

## Getting Started

### 1. Access Codespaces

**From GitHub Repository**:

1. Go to repository: `https://github.com/zyx-0314/ChronoBoard-Sample-Sprint-Learn-2025`
2. Click the green **Code** button
3. Select **Codespaces** tab
4. Click **Create codespace on main**

**From GitHub Dashboard**:

1. Navigate to `github.com/codespaces`
2. Click **New codespace**
3. Select repository
4. Choose branch (usually `main`)
5. Click **Create codespace**

### 2. Wait for Creation

- Codespace takes 30-60 seconds to create
- You'll see a progress indicator
- Environment is automatically configured

### 3. Start Coding

Once loaded, you have:
- Full VS Code editor in browser
- Terminal access
- All dependencies installed
- Ready to run application

## Codespace Configuration

### Configuration File

Create `.devcontainer/devcontainer.json` in repository root:

```json
{
  "name": "ChronoBoard Development",
  "image": "mcr.microsoft.com/devcontainers/php:8.1",
  
  "features": {
    "ghcr.io/devcontainers/features/node:1": {
      "version": "lts"
    },
    "ghcr.io/devcontainers/features/docker-in-docker:2": {}
  },
  
  "customizations": {
    "vscode": {
      "extensions": [
        "bmewburn.vscode-intelephense-client",
        "eamodio.gitlens",
        "editorconfig.editorconfig",
        "esbenp.prettier-vscode"
      ],
      "settings": {
        "editor.formatOnSave": true,
        "editor.tabSize": 4,
        "files.insertFinalNewline": true,
        "files.trimTrailingWhitespace": true
      }
    }
  },
  
  "forwardPorts": [8000, 3306, 6379],
  
  "postCreateCommand": "composer install && npm install",
  
  "remoteUser": "vscode"
}
```

### Dockerfile (Optional)

For custom requirements, create `.devcontainer/Dockerfile`:

```dockerfile
FROM mcr.microsoft.com/devcontainers/php:8.1

# Install additional packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set permissions
RUN chown -R vscode:vscode /workspace
```

### Docker Compose (For Services)

Create `.devcontainer/docker-compose.yml` for additional services:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    volumes:
      - ../:/workspace:cached
    command: sleep infinity
    network_mode: service:db

  database:
    image: mysql:8.0
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: chronoboard
      MYSQL_USER: chronoboard_user
      MYSQL_PASSWORD: chronoboard_password
      MYSQL_ROOT_PASSWORD: root_password
    volumes:
      - mysql-data:/var/lib/mysql

  cache:
    image: redis:7-alpine
    restart: unless-stopped

volumes:
  mysql-data:
```

Then update `devcontainer.json`:

```json
{
  "name": "ChronoBoard Development",
  "dockerComposeFile": "docker-compose.yml",
  "service": "app",
  "workspaceFolder": "/workspace",
  // ... rest of configuration
}
```

## Using Codespaces

### Opening Terminal

1. **From Menu**: Terminal → New Terminal
2. **Keyboard**: Ctrl+` (or Cmd+` on macOS)
3. **Multiple terminals**: Click + in terminal panel

### Running Application

```bash
# Start development server
php -S localhost:8000

# Or with Docker Compose
docker-compose up -d

# View in browser (forwarded port)
# Click "Ports" tab, then "Open in Browser" for port 8000
```

### Managing Ports

**View Forwarded Ports**:
1. Click **Ports** tab in bottom panel
2. See all forwarded ports
3. Click globe icon to open in browser

**Add Port Forwarding**:
1. Click **Ports** tab
2. Click **Forward a Port**
3. Enter port number
4. Set visibility (private/public)

### Using Git

Git is pre-configured with your GitHub credentials:

```bash
# Check status
git status

# Create branch
git checkout -b feature/new-feature

# Commit changes
git add .
git commit -m "Add new feature"

# Push to GitHub
git push origin feature/new-feature
```

### Installing Extensions

**From Extensions Panel**:
1. Click Extensions icon (Ctrl+Shift+X)
2. Search for extension
3. Click Install

**Recommended Extensions**:
- PHP Intelephense
- GitLens
- EditorConfig
- Docker
- ESLint (if using JavaScript)

### Accessing Database

**Using Terminal**:
```bash
# Connect to MySQL
mysql -h database -u chronoboard_user -p

# Import database
mysql -h database -u chronoboard_user -p chronoboard < backup.sql
```

**Using Database Client**:
- Forward port 3306
- Connect from local database client
- Use forwarded port URL

## Managing Codespaces

### Stopping Codespace

**From Codespace**:
1. Click Codespaces badge in bottom-left
2. Select **Stop Current Codespace**

**From GitHub**:
1. Go to `github.com/codespaces`
2. Find your codespace
3. Click ⋯ menu → Stop

### Starting Stopped Codespace

1. Go to `github.com/codespaces`
2. Find stopped codespace
3. Click name to restart

### Deleting Codespace

⚠️ This permanently deletes the codespace

1. Go to `github.com/codespaces`
2. Click ⋯ menu → Delete
3. Confirm deletion

**Note**: Code pushed to GitHub is safe

### Rebuilding Codespace

After changing configuration:

1. Press Ctrl+Shift+P (or Cmd+Shift+P)
2. Type "Rebuild Container"
3. Select **Codespaces: Rebuild Container**
4. Wait for rebuild to complete

## Working with Files

### Uploading Files

**Drag and Drop**:
- Drag files from your computer
- Drop into file explorer

**Using Upload**:
1. Right-click in file explorer
2. Select **Upload**
3. Choose files

### Downloading Files

1. Right-click file
2. Select **Download**
3. File saves to your computer

### Syncing Settings

Enable Settings Sync to keep preferences across codespaces:

1. Click gear icon → Settings Sync
2. Sign in with GitHub
3. Choose what to sync
4. Settings apply to all codespaces

## Environment Variables

### Setting Environment Variables

**Option 1: In .env file**
```bash
# Create .env file
cp .env.example .env

# Edit with your values
nano .env
```

**Option 2: In Codespace Secrets**

For sensitive data:
1. Go to GitHub Settings
2. Navigate to Codespaces → Secrets
3. Add new secret
4. Available in all codespaces

**Option 3: In devcontainer.json**

For non-sensitive defaults:
```json
{
  "containerEnv": {
    "APP_ENV": "development",
    "APP_DEBUG": "true"
  }
}
```

## Performance Tips

### Resource Allocation

Codespaces provides:
- **2-core**: Free tier, good for most work
- **4-core**: Better for intensive tasks
- **8-core**: Best performance (costs more)

Change machine type:
1. Stop codespace
2. Go to codespace settings
3. Change machine type
4. Start codespace

### Optimizing Startup

**Prebuilds**: Speed up codespace creation

1. Enable in repository settings
2. Codespaces → Prebuilds → New
3. Choose branch and schedule
4. Prebuilt containers create faster

**Lifecycle Scripts**:

```json
{
  "onCreateCommand": "npm install",     // Runs once on creation
  "updateContentCommand": "npm update", // Runs on rebuild
  "postStartCommand": "npm start"       // Runs every start
}
```

## Troubleshooting

### Codespace Won't Start

1. **Check GitHub Status**: Visit `githubstatus.com`
2. **Delete and Recreate**: Sometimes a fresh start helps
3. **Check Configuration**: Verify devcontainer.json syntax

### Port Not Accessible

1. **Check Port is Forwarded**: View Ports tab
2. **Make Port Public**: Right-click port → Port Visibility → Public
3. **Check Application is Running**: Terminal should show server running

### Slow Performance

1. **Upgrade Machine Type**: Use 4-core or 8-core
2. **Close Unused Tabs**: Free up memory
3. **Stop Background Processes**: Check running processes
4. **Clear Browser Cache**: Sometimes helps

### Changes Not Saved

1. **Check Auto-Save**: File → Auto Save
2. **Verify Connection**: Check network connection
3. **Save Manually**: Ctrl+S to force save

### Extension Not Working

1. **Reload Window**: Ctrl+Shift+P → Reload Window
2. **Reinstall Extension**: Uninstall and reinstall
3. **Check Compatibility**: Some extensions don't work in browser

## Best Practices

### Keep Codespaces Organized

✅ **Use Descriptive Names**
- Name codespaces by feature/branch
- Easier to identify later

✅ **Delete When Done**
- Clean up completed work
- Frees up space and resources

✅ **One Codespace per Feature**
- Don't reuse for different work
- Create new for new features

### Manage Resources

✅ **Stop When Not Using**
- Codespaces auto-stop after 30 min (default)
- Manually stop if stepping away

✅ **Don't Hoard Codespaces**
- Delete finished codespaces
- Keep only active ones

✅ **Use Appropriate Machine Type**
- 2-core for most work
- Upgrade only when needed

### Secure Your Work

✅ **Commit and Push Regularly**
- Codespaces can be deleted
- Code in GitHub is safe

✅ **Use Codespace Secrets**
- For API keys, passwords
- Don't commit sensitive data

✅ **Keep Environment Updated**
- Pull latest changes regularly
- Rebuild after config changes

## Codespaces vs Local Development

### When to Use Codespaces

✅ Quick contributions
✅ Working from different machines
✅ Consistent team environment
✅ No local setup possible
✅ Testing on different configurations

### When to Use Local

✅ Offline work needed
✅ Large file operations
✅ Specialized tools not in cloud
✅ Maximum performance needed
✅ Personal preference

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Run application
php -S localhost:8000

# Run tests
composer test

# Database operations
mysql -h database -u root -p

# Git operations
git status
git add .
git commit -m "message"
git push

# View logs
tail -f storage/logs/app.log

# Stop services
docker-compose down
```

## Keyboard Shortcuts

```
Open Command Palette:    Ctrl+Shift+P (Cmd+Shift+P)
Quick Open File:         Ctrl+P (Cmd+P)
Toggle Terminal:         Ctrl+` (Cmd+`)
New Terminal:            Ctrl+Shift+` (Cmd+Shift+`)
Split Editor:            Ctrl+\ (Cmd+\)
Toggle Sidebar:          Ctrl+B (Cmd+B)
Search Files:            Ctrl+Shift+F (Cmd+Shift+F)
Save File:               Ctrl+S (Cmd+S)
```

## Next Steps

Once your Codespace is running:

1. **Explore the interface**
   - Familiarize with VS Code in browser
   - Try different features
   - Customize to your preference

2. **Read documentation**
   - [Development Workflow](../workflows/development-workflow.md)
   - [Coding Standards](../../guidelines/coding-standards.md)
   - [Testing Strategy](../testing/testing-strategy.md)

3. **Start contributing**
   - Pick an issue
   - Create feature branch
   - Make changes and push

## Related Documentation

- [Environment Setup Guide](./environment-setup.md)
- [Docker Setup Guide](./docker-setup.md)
- [Development Workflow](../workflows/development-workflow.md)

## Getting Help

- **Codespaces Docs**: docs.github.com/codespaces
- **VS Code Docs**: code.visualstudio.com/docs
- **Team Support**: Ask in project channels

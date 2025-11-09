# YII

## Creating Migration

```cmd
docker-compose exec php php yii migrate/create migration_name_here
```

## Running Migrations

```cmd
docker-compose exec php php yii migrate
```

## Creating Controller

```cmd
docker-compose exec php php yii gii/controller --controllerClass=app\\controllers\\ControllerNameController --baseClass=yii\\web\\Controller
```

## Creating Model

```cmd
docker-compose exec php php yii gii/model --tableName=table_name --modelClass=ModelName
```

## Running Tests

```cmd
docker-compose exec php php vendor/bin/codecept run
```

# Docker

## Initializing Containers

```cmd
docker-compose up
```

### Attributes

- `-d`: Run containers in detached mode (background)
- `--watch`: Watch for changes and rebuild (if supported)
- `--build`: Force rebuild of images

## Building Images

```cmd
docker-compose build
```

## Removing Containers

```cmd
docker-compose down
```

## Viewing Logs

```cmd
docker-compose logs
```

## Following Logs

```cmd
docker-compose logs -f
```

## Executing Commands in Container

```cmd
docker-compose exec php bash
docker-compose exec mysql mysql -u root -p
```

## Database Operations

### Connect to MySQL

```cmd
docker-compose exec mysql mysql -u root -prootpassword yii2basic
```

### View Database Schema

```cmd
docker-compose exec mysql mysql -u root -prootpassword yii2basic -e "SHOW TABLES;"
docker-compose exec mysql mysql -u root -prootpassword yii2basic -e "DESCRIBE users;"
```

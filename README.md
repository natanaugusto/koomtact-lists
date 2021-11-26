

  

# Koomtact

![FlyingDonut Project](https://www.flyingdonut.io/api/projects/619c157c66aa032e09f29067/iterations/current/status.svg)

  

A simple contact importer while I'm trying to dance a little cumbia.

  

## How run this project

It's easy to run this project in development environments. You just must have [Docker](https://docs.docker.com/) installed.

[Install Docker](https://docs.docker.com/engine/install/)

  

### Running the project step-by-step

- Copy and configure the `.env` file

```shell

cp .env.example .env

vim .env

```

You can edit the .env file as you wish

```env

# Docker

HOST_SSH_PATH=~/.ssh

HOST_GITCONFIG_PATH=~/.gitconfig

WORKSPACE_GITHUB_SSH_KEY=GitHub

WORKSPACE_USER=workspace

WORKSPACE_INSTALL_COMPOSER=true

WORKSPACE_COMPOSER_HASH=906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8

WORKSPACE_INSTALL_ZSH=true

  
  

PHP_VERSION=8

PHP_FPM_PORT=9000

  

NGINX_PORT=80

  

MYSQL_VERSION=8

MYSQL_DATABASE=koomtact

MYSQL_ROOT_PASSWORD=root

MYSQL_PORT=3306

MYSQL_USER='dancer'

MYSQL_PASSWORD='dancer'

  

REDIS_VERSION=6.2

REDIS_PORT=6379

  

# Laravel

APP_NAME=koomtact

APP_ENV=local

APP_KEY=

APP_DEBUG=true

APP_URL=http://koomtact.local

  

LOG_CHANNEL=stack

LOG_DEPRECATIONS_CHANNEL=null

LOG_LEVEL=debug

  

DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DB_DATABASE=koomtact

DB_USERNAME=dancer

DB_PASSWORD=dancer

  

BROADCAST_DRIVER=log

CACHE_DRIVER=file

FILESYSTEM_DRIVER=local

QUEUE_CONNECTION=sync

SESSION_DRIVER=file

SESSION_LIFETIME=120

  

MEMCACHED_HOST=127.0.0.1

  

REDIS_HOST=127.0.0.1

REDIS_PASSWORD=null

REDIS_PORT=6379

  

MAIL_MAILER=smtp

MAIL_HOST=mailhog

MAIL_PORT=1025

MAIL_USERNAME=null

MAIL_PASSWORD=null

MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS=null

MAIL_FROM_NAME="${APP_NAME}"

  

AWS_ACCESS_KEY_ID=

AWS_SECRET_ACCESS_KEY=

AWS_DEFAULT_REGION=us-east-1

AWS_BUCKET=

AWS_USE_PATH_STYLE_ENDPOINT=false

  

PUSHER_APP_ID=

PUSHER_APP_KEY=

PUSHER_APP_SECRET=

PUSHER_APP_CLUSTER=mt1

  

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"

MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```

- Up & Run the project

```shell

# That will up all containers(php-fpm, nginx, mysql, redis)

docker-compose up -d

# This project has an workspace for PHP.

# You can access that by:

docker-compose exec -u workspace php-fpm zsh

# Then you'll be in the root of the project.

# And you can see something like ->/workspace

# The workspace contains some alias to help us to run some commands.

# Below I'll use the `art` alias. Which is the alias for `php artisan`

composer install --verbose

art key:generate

art migrate

# Others artisan commands

```

- Install the front-end

On your host terminal run the commands below:(The npm is not available on workspace. Sorry about that!)

```shell

npm install

npm run dev

```
The project is using [laravel/breeze](https://github.com/laravel/breeze) on frontend.

-  Add the site on /etc/host
```shell
sudo vim /etc/hosts

# Add this line
127.0.0.1       koomtact.local
```

That's all folks!!

# Koomtact

![FlyingDonut Project](https://www.flyingdonut.io/api/projects/619c157c66aa032e09f29067/iterations/current/status.svg)

A simple contact importer while I'm trying to dance a little cumbia.

## How run this project

It's easy to run this project in development environments. You just must have [Docker](https://docs.docker.com/)
installed.

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
DOCKER_HOST_SSH_PATH=~/.ssh
DOCKER_HOST_GITCONFIG_PATH=~/.gitconfig
DOCKER_WORKSPACE_GITHUB_SSH_KEY=GitHub
DOCKER_WORKSPACE_USER=workspace
DOCKER_WORKSPACE_INSTALL_COMPOSER=true
DOCKER_WORKSPACE_COMPOSER_HASH=906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8
DOCKER_WORKSPACE_INSTALL_ZSH=true


DOCKER_PHP_VERSION=8
DOCKER_PHP_FPM_PORT=9000

DOCKER_NGINX_PORT=80

DOCKER_MYSQL_VERSION=8
DOCKER_MYSQL_DATABASE=koomtact
DOCKER_MYSQL_ROOT_PASSWORD=root
DOCKER_MYSQL_PORT=3306
DOCKER_MYSQL_USER='dancer'
DOCKER_MYSQL_PASSWORD='dancer'

DOCKER_REDIS_VERSION=6.2
DOCKER_REDIS_PORT=6379

# Laravel
APP_NAME=koomtact
APP_ENV=local
APP_KEY=base64:bWjEMJ/9T7w03NjLni2nvCQwySln1Dte5DiEaobNN9c=
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
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=redis
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

- Add the site on /etc/host

```shell
sudo vim /etc/hosts

# Add this line
127.0.0.1       koomtact.local
```
- Now acesse the local site: [http://koomtact.local/](http://koomtact.local/)

### How to use this project
If all the last step goes well. Now you can access the project by the URL [http://koomtact.local/](http://koomtact.local/).

- Create a user [http://koomtact.local/register](http://koomtact.local/register)
- Goes to the [Import CSV File](http://koomtact.local/file/import) and import a file from [sample]
-  Do the from/to configuration for the file and contacts
- To run the queue, use:
    ```shell
    art queue:work
    ```
- To run the tests:
  ```shell
  art test
  ```
### Some considerations
I really tried to do my best. But at the last of the project, I was really tired.

I know which this project has some bugs. All project has. But try to focus on my bests.

### How much time did I spend with this test
| Koombea Assessment | 31:53:57 |
|--|--|
| As a user, I must be able to upload a CSV file for processing | 10:41:23 |
| As a user, I should be able to see a list of imported files with their respective status | 00:24:27 |
| As a user, I should be able to see a log of the contacts that could not be imported and the error associated with it. | 01:38:01 |
| Create the Flying Donut project for the Koombea test | 01:44:02 |
| Interview with the Koombea Hiring Manager | 02:32:13 |
| As a system, I must process the content of the CSV file. The following validations must have the elements in the CSV file |06:33:46
| Create a basic development environment with the base code to initiate the project | 05:10:24 |
| As a user, I must be able to register on the platform. For this, it will only be necessary to enter a username and password | 01:27:35
| As a user, I must be able to log into the system using an email and a password | 01:11:50 |
| As a user, I should be able to see a summary of the contacts I have imported | 00:30:16 |
---
Thank you so much for this opportunity.

That's all folks!!

# realtime-chat
It's a simple chat application with Laravel 5, Redis, node.js, socket.io library;

## Installation
Clone this repository

```bash
$ cd realtime-chat
$ composer install && npm install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan storage:link
```
Modify `.env` file 

```.env
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD=password

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```
And run the migrations

```bash
$ php artisan migrate
```

## Run
```bash
$ node node_server/server.js
```

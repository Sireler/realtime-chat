# realtime-chat
It's a simple chat application with Laravel 5, Redis, node.js, socket.io library;

## Installation
Clone this repository and then

```
$ cd realtime-chat
$ composer install && npm install
$ cp .env.example .env
$ php artisan key:generate
```
Modify `.env` file and run the migrations

```
$ php artisan migrate
```

## Run
```bash
$ node node_server/server.js
```

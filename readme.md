# realtime-chat
It's a simple chat application with Laravel 5, Redis, node.js, socket.io library;

## Installation
Clone this repository and then

```bash
$ cd realtime-chat
$ composer install && npm install
$ cp .env.example .env
$ php artisan key:generate
```
Modify `.env` file and run the migrations

```bash
$ php artisan migrate
```

## Run
```bash
$ node node_server/server.js
```

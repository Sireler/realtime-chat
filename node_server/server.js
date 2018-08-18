var io = require('socket.io')(6001),
    Redis = require('ioredis'),
    redis = new Redis(),
    request = require('request');

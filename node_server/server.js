var io = require('socket.io')(6001),
    Redis = require('ioredis'),
    redis = new Redis(),
    request = require('request');


// check user auth
io.use(function(socket, next) {
    request.get({
        url: socket.request.headers.origin + '/socket/check-auth',
        headers: {cookie: socket.request.headers.cookie},
        json: true
    }, function(error, response, json) {
        return json.auth ? next() : next(new Error('Auth error'));
    });
});

redis.psubscribe('*', function (error, count) {
    // ---
});

redis.on('pmessage', function (pattern, channel, message) {

    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, {message: message.data.message, date: message.data.createdDate, fromUser: {
            username: message.data.username,
            avatar: message.data.avatar
        }});

    console.log(channel, message)
});
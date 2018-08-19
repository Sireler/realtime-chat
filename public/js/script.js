var socket = io(':6001');

Notify = {
    TYPE_INFO: 0,
    TYPE_SUCCESS: 1,
    TYPE_WARNING: 2,
    TYPE_DANGER: 3,

    generate: function (aText, aOptHeader, aOptType_int) {
        var lTypeIndexes = [this.TYPE_INFO, this.TYPE_SUCCESS, this.TYPE_WARNING, this.TYPE_DANGER];
        var ltypes = ['alert-info', 'alert-success', 'alert-warning', 'alert-danger'];
        var ltype = ltypes[this.TYPE_INFO];

        if (aOptType_int !== undefined && lTypeIndexes.indexOf(aOptType_int) !== -1) {
            ltype = ltypes[aOptType_int];
        }

        var lText = '';
        if (aOptHeader) {
            lText += "<h4>"+aOptHeader+"</h4>";
        }
        lText += "<p style='font-size: 0.75em'>"+aText+"</p>";
        var lNotify_e = $("<div class='alert "+ltype+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>"+lText+"</div>");

        setTimeout(function () {
            lNotify_e.alert('close');
        }, 5000);
        lNotify_e.appendTo($("#notifies"));
    }
};

var params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );

console.log( params['to']);

socket.on('connect', function() {

})

socket.on('connect_error', function(error) {
    socket.close();
    console.log('Невозможно соедениться с сервером');
});

socket.on('error', function(error) {
    console.warn('Error: ' + error)
});


socket.on('chat-' + myId +':message', function (data) {

    if (params['to'] == data.message.from_id) {
        var strDate = $('<div class="chat_time float-right">').text(data.date);
        var body = $('<div class="chat-body1 clearfix">');
        var p = $('<p class="rounded">');
        var span = $('<span class="chat-img1 float-left">').append($('#chat-to-user-avatar').clone());
        var li = $('<li class="left clearfix">').append(span).append(body.append(p.text(data.message.content)).append(strDate));

        $('ul.list-unstyled').prepend(li);
    } else {
        Notify.generate(data.message.content, '<img style="width: 24px; height: 24px; margin-right: 10px;" src="'+ data.message.from_user.avatar +'">' + 'Message from ' + data.message.from_user.name + ':', 0);
    }


});

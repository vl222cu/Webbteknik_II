function MessageLongPolling() {

    this.getMessage = function(callback, lastTime) {
       
        var that = this;
        var latest = null;

        $.ajax({
            type: "POST",
            url: "messageEngine.php",
            dataType: 'json',
            data: {
                mode: 'get', 
                numberOfMessages: MessageBoard.messages.length, 
                lastTime: lastTime
            },
            timeout: 30000,
            cache: false,
            success: function (data) {

                if (data.result) {

                    callback(data.message);
                    latest = data.latestMessageTime;
                }
            },

            complete: function () {

                that.getMessage(callback, latest);
            },
             error: function(e) {

                console.log(e);
            }
        });
    };

    this.postMessage = function(user, message, callback) {

        $.ajax({
            type: 'POST',
            url: 'messageEngine.php',
            dataType: 'json',
            data: {
                mode: 'post',
                user: user,
                message: message,
                token: $('#token').val()
            },
            success: function(data) {
                
                callback(data);
            
            },
            error: function(e) {

                console.log(e);
            }
        });
    };
};

var messageLongPolling = new MessageLongPolling();
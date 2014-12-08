var MessageBoard = {

    messages: [],
    textField: null,
    messageArea: null,
    lastMsgCount: 0,

    init:function(e)
    {
	
		    MessageBoard.textField = document.getElementById("inputText");
		    MessageBoard.nameField = document.getElementById("inputName");
            MessageBoard.messageArea = document.getElementById("messagearea");
            MessageBoard.tokenField = document.getElementById("csrfToken");
    
            // Add eventhandlers    
            document.getElementById("inputText").onfocus = function(e){ this.className = "focus"; }
            document.getElementById("inputText").onblur = function(e){ this.className = "blur" }
            document.getElementById("buttonSend").onclick = function(e) {MessageBoard.sendMessage(); return false;}
//            document.getElementById("buttonLogout").onclick = function(e) {MessageBoard.logout(); return false;}
    
            MessageBoard.textField.onkeypress = function(e){ 
                                                    if(!e) var e = window.event;
                                                    
                                                    if(e.keyCode == 13 && !e.shiftKey){
                                                        MessageBoard.sendMessage(); 
                                                       
                                                        return false;
                                                    }
                                                }
    MessageBoard.getMessages();
    },
    getMessages:function() {

        var ajaxCall = function() {

            $.ajax({
    			type: "GET",
    			url: "functions.php",
    			data: {function: "getMessages"}
    		}).done(function(data) { // called when the AJAX call is ready
    			var msgCounter = 0;			
    			data = JSON.parse(data);

                for(var msg in data) {
                    msgCounter++;
                }
    			if(msgCounter > MessageBoard.lastMsgCount) {

                    MessageBoard.lastMsgCount = msgCounter;
                    MessageBoard.messageArea.innerHTML = "";

        			for(var mess in data) {
        				var obj = data[mess];
        			    var text = obj.name +" said:\n" +obj.message;
        				var mess = new Message(text, new Date());
                        var messageID = MessageBoard.messages.push(mess)-1;

                        MessageBoard.renderMessage(messageID);
        				
        			}
        			document.getElementById("nrOfMessages").innerHTML = msgCounter;
        		}	
    		});
	    }

        setInterval(function() {
            ajaxCall();
        },2000);

        ajaxCall();
    },
    sendMessage:function(){
        
        if(MessageBoard.textField.value == "") return;
        
        // Make call to ajax
        $.ajax({
			type: "GET",
		  	url: "functions.php",
		  	data: {function: "add", name: MessageBoard.nameField.value, message: MessageBoard.textField.value, token: MessageBoard.tokenField.value}
		}).done(function(data) {
		  window.location.reload();
		});
    
    },
    renderMessages: function(){
        // Remove all messages
        MessageBoard.messageArea.innerHTML = "";
     
        // Renders all messages.
        for(var i=0; i < MessageBoard.messages.length; ++i){
            MessageBoard.renderMessage(i);
        }        
        
        document.getElementById("nrOfMessages").innerHTML = MessageBoard.messages.length;
    },
    renderMessage: function(messageID){
        // Message div
        var div = document.createElement("div");
        div.className = "message";
       
        // Clock button
        aTag = document.createElement("a");
        aTag.className = "sprite";
        aTag.href="#";
        aTag.onclick = function(){
			MessageBoard.showTime(messageID);
			return false;			
		}

        div.appendChild(aTag);
       
        // Message text
        var text = document.createElement("p");
        text.innerHTML = MessageBoard.messages[messageID].getHTMLText();        
        div.appendChild(text);
            
        // Time - Should fix on server!
        var spanDate = document.createElement("span");
        spanDate.appendChild(document.createTextNode(MessageBoard.messages[messageID].getDateText()));

        div.appendChild(spanDate);        
        
        var spanClear = document.createElement("span");
        spanClear.className = "clear";

        div.appendChild(spanClear);        
        
        MessageBoard.messageArea.appendChild(div);       
    },
    removeMessage: function(messageID){
		if(window.confirm("Vill du verkligen radera meddelandet?")){
        
			MessageBoard.messages.splice(messageID,1); // Removes the message from the array.
        
			MessageBoard.renderMessages();
        }
    },
    showTime: function(messageID){
         
         var time = MessageBoard.messages[messageID].getDate();
         
         var showTime = "Created "+time.toLocaleDateString()+" at "+time.toLocaleTimeString();

         alert(showTime);
    }
};

window.onload = MessageBoard.init;
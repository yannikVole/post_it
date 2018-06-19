var chat_module = (function(root){
    //private scope
    var sidebar = sidebar_module;

    var url_root = root
    var fetch_message_interval_id = undefined;
    var cur_user_id = loggedInUser;
    var currentReceiver = undefined;

    var current_messages;
    var last_messages;

    //cache DOM elements
    var chatBox = $("#chatbox-main");
    var chatInput = chatBox.find("#chatbox-input");
    var messagesAnchor = chatBox.find(".chatbox-msg-container");
    var chatBoxHeader = chatBox.find(".chatbox-heading");

    //bind events
    chatInput.on("keyup", function(event){
        if(event.keyCode == 13 && event.value != "" && currentReceiver != undefined){
            sendMessage(loggedInUser,currentReceiver.id, event.target.value);
            event.target.value = "";
        }
    });

    chatBoxHeader.on("click",closeChat);

    sidebar_module.setOnUpdateCallback(onSidebarFinishedLoading);

    function onSidebarFinishedLoading(){
        sidebar_module.getUsers().forEach( (userObj) => {
            userObj.element.addEventListener("click", () => {
                setCurrentReceiver(userObj.user);
                openChat();
            });
        });
    }

    function setCurrentReceiver(receiver){
        currentReceiver = receiver;
    }

    function openChat(){
        chatBox.css("height","300px");
        chatBoxHeader.text(currentReceiver.name);
    }

    function appendMessageToAnchor(msg){
        const node = document.createElement("div");
        node.className = "chatbox-msg";
        node.innerHTML = '<p class="chatbox-msg-header">'+msg.Sender+':</p><p class="chatbox-msg-body">'+msg.Message+'</p>';
        messagesAnchor.appendChild(node);
    }

    function compareAsStrings(json1,json2){
        return JSON.stringify(json1) === JSON.stringify(json2);
    }

    function fetchMessages(sender_id,receiver_id){
        var formData = new FormData();
        formData.append("sender",sender_id);
        formData.append("receiver",receiver_id);
        $.ajax({
            url:url_root + '/api/get_messages',
            type:"POST",
            data:formData,
            contentType:false,
            processData:false,
            complete:function(res){
                current_messages = res.responseJSON;
                if(!compareAsStrings(current_messages,last_messages)){
                    messagesAnchor.innerHTML = "";
                    current_messages.forEach( msg => {
                        appendMessageToAnchor(msg);
                    });
                }
                last_messages = current_messages;
            }
        });
    }

    function sendMessage(sender_id,receiver_id,message_text) {
        var fd = new FormData();
        fd.append("sender",sender_id);
        fd.append("receiver",receiver_id);
        fd.append("msg",message_text);

        $.ajax({
            url:this.url_root + "/api/send_message",
            type:"POST",
            data:formData,
            complete: function (res) {

            },
            contentType:false,
            processData:false
        });
    }

    function closeChat(){
        chatBox.css("height","0px");
    }

    return {
        //public 'scope'
        submitMessage:function(sender_id,receiver_id,msg){
            this.sendMessage(sender_id,receiver_id,msg);
        },
        updateChat:(sender_id,receiver_id, keep_updated = false) =>{
            if(fetch_message_interval_id != undefined){
                clearInterval(fetch_message_interval_id);
                fetch_message_interval_id = undefined;
            }
            if(!keep_updated){
                this.fetch_messages(sender_id,receiver_id);
            } else {
                fetch_message_interval_id = setInterval(() =>{this.fetch_messages(sender_id,receiver_id)},500);
            }
        },
        stopChatUpdate:() => {
            if(fetch_message_interval_id != undefined){
                clearInterval(fetch_message_interval_id);
                fetch_message_interval_id = undefined;
            }
        },
        openChatWindow: () => {
            openChat();
        },
        closeChatWindow: () => {
            closeChat();
        }

    }
})(URL_ROOT);



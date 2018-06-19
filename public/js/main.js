
const URL_ROOT = "http://localhost/shareposts"
const MESSAGE_FETCH_INTERVAL = 500; //in milliseconds
var online_users = [];
var response_data;
var online_list_anchor = document.getElementById("online_users_anchor");
var current_receiver_id = -1;
var chatInputNode = document.getElementById("chatbox-input");
var chatInterval;
var oldMsgs = [];


function init(){
    update_online_list();
    var intervall = setInterval( () => {
        update_online_list();
    }, 5000);

    chatInputNode.addEventListener("keyup", function(event) {
        if(current_receiver_id > -1){
            event.preventDefault();
            if(event.keyCode == 13){
                sendChatMsg(loggedInUser,current_receiver_id, event.target.value);
                event.target.value = "";
            }
        }
    });
}

function update_online_list(){ 

    $.ajax({
        url: URL_ROOT +'/api/get_online_users',
        dataType: "json",
        complete:function(response){
            online_list_anchor.innerHTML = "";
            response.responseJSON.forEach( (user,index) =>{
                const node = document.createElement("div");
                node.className = "list-group-item";
                node.innerHTML = `<i class="fas fa-signal"></i> ${user.name}`;
                online_list_anchor.appendChild(node);
                node.addEventListener("click",  () => {
                    openChat(loggedInUser,user);
                    current_receiver_id = user.id;
                }, false);
            });
        }
    });
}


const chatBox = document.getElementById("chatbox-main");

function openChat(sender, receiver){
    chatBox.getElementsByClassName("chatbox-heading")[0].textContent = receiver.name;
    chatBox.style.height = "300px";
    if(chatInterval){
        console.log("stop fetching messages")
        clearInterval(chatInterval);
    }
    chatInterval = setInterval(() => {fetchMessages(sender,receiver)},MESSAGE_FETCH_INTERVAL);
}

function fetchMessages(sender,receiver){
    var formData = new FormData();
    formData.append("sender",sender);
    formData.append("receiver",receiver.id);
    $.ajax({
        url:URL_ROOT + '/api/get_messages',
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        complete:function(res){
            var msgs = res.responseJSON;
            var msgAnchor = document.getElementsByClassName("chatbox-msg-container")[0];
            if(!compareAsStrings(msgs,oldMsgs)){
                msgAnchor.innerHTML = "";
                msgs.forEach( msg => {
                    const node = document.createElement("div");
                    node.className = "chatbox-msg";
                    node.innerHTML = '<p class="chatbox-msg-header">'+msg.Sender+':</p><p class="chatbox-msg-body">'+msg.Message+'</p>';
                    msgAnchor.appendChild(node);
            });
            }

            oldMsgs = msgs;
            console.log("fetched chat messages");
        }
    });
}

function closeChat(){
    chatBox.style.height = "0px";
}

function sendChatMsg(sender_id, receiver_id, msg){
    var formData = new FormData();
    formData.append("sender",sender_id);
    formData.append("receiver",receiver_id);
    formData.append("msg",msg);

    $.ajax({
        url:URL_ROOT + "/api/send_message",
        type:"POST",
        data:formData,
        complete: function (res) {
        },
        contentType:false,
        processData:false
    });
}

function compareAsStrings(json1,json2){
    return JSON.stringify(json1) === JSON.stringify(json2);
}

init();



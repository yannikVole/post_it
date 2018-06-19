export default (function(urlRoot){
    //private scope
    var url_root = urlRoot;

    //cache DOM elements
    var chatInput = $("#chatbox-input");
    var messagesAnchor = $("#chatbox-msg-container");



    return {
        //public 'scope'
        sendMessage:(sender_id,receiver_id,message) => {
            var fd = new FormData();
            fd.append("sender",sender_id);
            fd.append("receiver",receiver_id);
            fd.append("msg",message);
        }
    }
})(URL_ROOT);
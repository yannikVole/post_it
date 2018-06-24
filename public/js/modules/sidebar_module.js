var sidebar_module = (function(root){
    var url_root = root;
    var online_users = [];
    var user_objects = [];
    var intervalId = undefined;
    var onUpdateCallback = undefined;
    //cache DOM elements
    var list_anchor = $("#online_users_anchor")[0];

    function fetchOnlineUsers(){ 
        $.ajax({
            url: url_root +'/api/get_online_users',
            dataType: "json",
            complete:function(response){
                user_objects = response.responseJSON;
                updateListView(user_objects);
            }
        });
    }

    function updateListView(users){
        clearAnchorChildren();
        users.forEach( user => {
            appendToAnchor(user);
        });
        onUpdateCallback();
    }

    function bindClickEvents(func){
        for(var i = 0; i < online_users.length; i++){
            online_users_elements[i].on("click",func(online_users[i]));
        }
    }

    function appendToAnchor(user){
        const node = document.createElement("div");
        node.className = "list-group-item";
        node.innerHTML = `<i class="fas fa-signal"></i> ${user.name}`;
        list_anchor.appendChild(node);
        online_users.push({
            user:user,
            element:node
        });
    }

    function clearAnchorChildren(){
        list_anchor.innerHTML = "";
        online_users = [];
    }

    return {
        bindClickEventsToElements: function(func){
            bindClickEvents(func);
        },
        getUsers:function(){
            return online_users;
        },
        startFetching:function(){
            fetchOnlineUsers();
            intervalId = setInterval(function(){
                fetchOnlineUsers();
            },5000);
        },
        setOnUpdateCallback(cb){
            onUpdateCallback = cb;
        }
    };
})(URL_ROOT);

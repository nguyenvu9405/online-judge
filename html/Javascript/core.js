//notification

var noti_container= document.getElementById("notification-container");

function createIcon(name)
{
    var node = document.createElement("i");
    node.classList.add("material-icons");
    var name = document.createTextNode(name);
    node.appendChild(name);
    return node;
}

function addNoti(title, message, status)
{
    var node = document.createElement("div");
    node.classList.add("notification","card");
    var titleNode = document.createElement("div");
    if (status==0)titleNode.classList.add("title");
    else titleNode.classList.add("title","warning");
    var cancelButton = document.createElement("button");
    cancelButton.classList.add("cancel");
    cancelButton.appendChild(createIcon("clear"));
    cancelButton.addEventListener("click",function () {
        node.style.display = "none";
    });
    var spanNode =  document.createElement("span");
    spanNode.appendChild(document.createTextNode(title));
    titleNode.appendChild(createIcon("notifications"));
    titleNode.appendChild(spanNode);
    titleNode.appendChild(cancelButton);
    node.appendChild(titleNode);
    var contentNode= document.createElement("div");
    contentNode.classList.add("content");
    contentNode.appendChild(document.createTextNode(message));
    node.appendChild(titleNode);
    node.appendChild(contentNode);
    noti_container.appendChild(node);
}

// top_nav

var user_dropdown_button = document.getElementById("user-button");
var user_dropdown_container = user_dropdown_button.nextElementSibling;
var hambuger_button = document.getElementById("hambuger");
var side_bar = document.getElementById("left-side-nav");
var body = document.getElementsByTagName("html").item(0);
var scrim = document.getElementById("scrim");

function userDropdDownToggle(close)//1 la toggle, //2 remove, //3 open
{
    if (close==1)
    {
        user_dropdown_container.classList.toggle("expand");
    }
    else if(close==2)
    {
        user_dropdown_container.classList.remove("expand");
    }
    else if (close==3)
    {
        user_dropdown_container.classList.add("expand");
    }
}

user_dropdown_button.addEventListener("click",function (e) {
    e.stopPropagation();
    userDropdDownToggle(1);
});

user_dropdown_container.addEventListener("click",function (e) {
    e.stopPropagation();
});

function sideBarToggle(close){ //1 la toggle, //2 remove, //3 open
    if (close==1)
    {
        scrim.classList.toggle("expand");
        side_bar.classList.toggle("expand");
    }
    else
    if (close==2)
    {
        scrim.classList.remove("expand");
        side_bar.classList.remove("expand");
    }
    else
    {
        scrim.classList.add("expand");
        side_bar.classList.add("expand");
    }
}

hambuger_button.addEventListener("click", function(e){
    e.stopPropagation();
    sideBarToggle(1);
});

side_bar.addEventListener("click",function(e){
    e.stopPropagation();
});

body.addEventListener("click",function(e){
    sideBarToggle(2);
    userDropdDownToggle(2);
});


// Submission Modal
var modal = document.getElementById("modal");
var codeEditor = document.getElementById("code-editor");
if (modal)
{
    var closeButton = modal.getElementsByClassName("close-button")[0];
    closeButton.addEventListener("click",function () {
        modal.style.display = "none";
    });
}
window.onmouseup=function (ev) {
    if (ev.target==modal)
    {
        modal.style.display = "none";
    }
};

var subLinks = document.getElementsByClassName("sub-link");
for (var i=0, len=subLinks.length; i<len; i++)
{
    item = subLinks[i];
    item.addEventListener("click",function(){
        var subId = this.getAttribute("sub-id");
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (xhttp.readyState==4 && xhttp.status==200)
            {
                editor.setValue(xhttp.responseText,-1);
                editor.scrollToLine(1);
                modal.style.display = "block";

            }
        };
        xhttp.open("GET","/get_sub?id="+subId,true);
        xhttp.send();
    });
}
var main_col = document.getElementById("main-col");

function createNotiPanel(status, msg)
{
    var panel = document.createElement("div");
    var container = document.createElement("div");
    var span = document.createElement("span");
    container.className="body-container";
    span.appendChild(document.createTextNode(msg));

    var icon = null;
    if (status==0)
    {
        icon = createIcon("error");
        panel.className = "card panel error-style col-s-12";
    }
    else if (status==1)
    {
        icon = createIcon("check_circle");
        panel.className = "card panel success-style col-s-12";
    }
    container.appendChild(icon);
    container.appendChild(span);
    panel.appendChild(container);
    return panel;
}

function addNotiPanel(status, msg)
{
    if (main_col!=null)
    {
        main_col.insertBefore(createNotiPanel(status,msg),main_col.firstElementChild);
    }
}
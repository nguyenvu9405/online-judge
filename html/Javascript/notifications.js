var noti_container= document.getElementById("notification-container");

function createIcon(name)
{
    var node = document.createElement("i");
    node.classList.add("material-icons");
    var name = document.createTextNode(name);
    node.appendChild(name);
    return node;
}

function addNoti(title, message)
{
    var node = document.createElement("div");
    node.classList.add("notification","card");
    var titleNode = document.createElement("div");
    titleNode.classList.add("title");
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
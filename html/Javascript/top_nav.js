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



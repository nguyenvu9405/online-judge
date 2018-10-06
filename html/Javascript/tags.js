// tags

var tagForm= document.getElementsByClassName("tag-form")[0];
var tagContainer = document.getElementById("tag-box");
var tagInput = document.getElementById("tag-input");
var tagValues= document.getElementById("tag-values");
var chosenTags = new Set();
var loadedTags = new Set();


tagInput.addEventListener("keydown",function (e) {
    if (e.keyCode==13)
    {
        var txt= this.value;
        if (txt) {
            e.preventDefault();
            e.stopPropagation();
        }
    }
});

tagInput.addEventListener("keyup",function (e) {
    if (e.keyCode == 13) {
        var txt = this.value;
        if (txt)
        {
            e.preventDefault();
            this.value = "";
            addTag(txt);
        }
    }
});

function addTag(txt){
    if (chosenTags.has(txt) || chosenTags.size==5) return;
    else
    {
        chosenTags.add(txt);
        if (typeof tagsValidation !== "undefined"){
            var size = chosenTags.size;
            if (1<=size && size<=5)
                tagContainer.nextElementSibling.className = "helper-text hint";
        }
    }
    var newTag = document.createElement("div");
    newTag.classList.add("tag","deletable-tag");
    var span = document.createElement("span");
    span.appendChild(document.createTextNode(txt));
    var icon = document.createElement("i");
    icon.classList.add("material-icons", "close-tag");
    icon.appendChild(document.createTextNode("cancel"));
    newTag.appendChild(span);
    newTag.appendChild(icon);
    icon.addEventListener("click",function(){
        var tag = this.parentNode;
        var txt = this.previousElementSibling.innerHTML;
        tag.parentNode.removeChild(tag);
        chosenTags.delete(txt);
        if (typeof tagsValidation !== "undefined"){
            var size = chosenTags.size;
            if (1<=size && size<=5)
                tagContainer.nextElementSibling.className = "helper-text hint";
        }
    });
    tagContainer.insertBefore(newTag,tagInput);
}


if (tagForm)
{
    tagForm.addEventListener("submit",function(e){
        tagValues.value = JSON.stringify(Array.from(chosenTags));

    });
}


tagInput.addEventListener("keyup",function () {
   var str = this.value;
   var xhttp= new XMLHttpRequest();
   var input = this;
   var datalist = input.nextElementSibling;
   xhttp.onreadystatechange = function () {
       if (this.readyState==4 && this.status==200)
       {
            var arr = JSON.parse(this.responseText);
            fragment = document.createDocumentFragment();
            arr.forEach(function (item) {
                var tag = item["tag"];
                if (!loadedTags.has(tag))
                {
                    var option = document.createElement("option");
                    option.value = tag;
                    fragment.appendChild(option);
                    loadedTags.add(tag);
                }
            });
            datalist.appendChild(fragment);
       }
   };
   xhttp.open("GET","get_tags.php?keyword="+str,true);
   xhttp.send();
});

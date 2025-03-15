let storedFiles = [];

function categoryChanged(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("subcategory").innerHTML =this.responseText;
    }
    xhttp.open("GET", "subcategoryOptions.php?categoryId="+document.getElementById("category").value, true);
    xhttp.send();
}

document.getElementById("category").addEventListener("change", function(){categoryChanged()});

document.addEventListener("DOMContentLoaded", function(){
    categoryChanged()
    var idElement=document.getElementById("id");
    if(idElement!=null){
        var id=idElement.value;
        var subcategoryOptions = document.getElementById("subcategory").options;
        for (var i=0; i<subcategoryOptions.length; i++)
            if (subcategoryOptions[i].value==id){
                subcategoryOptions[i].selected = true;
                break;
            }
    }
})

document.getElementById("files").addEventListener("change", function(){
    filesInput=document.getElementById("files");
    const files = filesInput.files;
    for (let file of files) {
        storedFiles.push(file);
    }
    var newFiles = document.getElementById("files").files;
    var imagesList = document.getElementById("images");
    for (var i = 0; i < newFiles.length; i++) {
        var div = document.createElement("div");
        div.style.position = "relative";
        div.style.display = "inline-block";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "newImages[]";
        input.value = files[i].name;
        div.appendChild(input);

        var img = document.createElement("img");
        img.src = URL.createObjectURL(newFiles[i]);
        img.width = 100;
        img.height = 100;
        div.appendChild(img);

        var span = document.createElement("span");
        span.style.position = "absolute";
        span.style.top = "0";
        span.style.right = "0";
        span.style.cursor = "pointer";
        span.innerHTML = "&times;";
        span.onclick = function() {
            this.parentElement.remove();
        };
        div.appendChild(span);

        imagesList.appendChild(div);
    }
    const dataTransfer = new DataTransfer();
    for (var i = 0; i < storedFiles.length; i++) {
        dataTransfer.items.add(storedFiles[i]);
    }
    filesInput.files = dataTransfer.files;
})
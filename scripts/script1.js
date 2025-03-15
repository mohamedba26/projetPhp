let storedFiles = [];

function categoryChanged(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("subcategory").innerHTML =this.responseText;
    }
    var idElement=document.getElementById("id");
    if(idElement==null)
        xhttp.open("GET", "subcategoryOptions.php?categoryId="+document.getElementById("category").value, true);
    else
        xhttp.open("GET", "subcategoryOptions.php?categoryId="+document.getElementById("category").value+"&productId="+idElement.value, true);
    xhttp.send();
}

document.getElementById("category").addEventListener("change", function(){categoryChanged()});

document.addEventListener("DOMContentLoaded", function(){
    categoryChanged();
    if(document.getElementById("images").childElementCount==0)
        document.getElementById("files").setAttribute("required", "required");
    else
        document.getElementById("files").removeAttribute("required");
})

document.getElementById("files").addEventListener("change", function(){
    filesInput=document.getElementById("files");
    const files = filesInput.files;
    for(let file of files) {
        storedFiles.push(file);
    }
    var newFiles = document.getElementById("files").files;
    var imagesList = document.getElementById("images");
    for (var i = 0; i < newFiles.length; i++) { 
        var div = document.createElement("div");
        div.style.position = "relative";
        div.style.display = "inline-block";

        var img = document.createElement("img");
        img.src = URL.createObjectURL(newFiles[i]);
        img.id = "img"+newFiles[i].name;
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
            imageId = this.parentElement.querySelector("img").id;
            for (var i = 0; i < storedFiles.length; i++)
                if (imageId == "img"+storedFiles[i].name){
                    storedFiles.splice(i, 1);
                    break;
                }
            this.parentElement.remove();
            if(document.getElementById("images").childElementCount==0)
                document.getElementById("files").setAttribute("required", "required");
            else
                document.getElementById("files").removeAttribute("required");
            const dataTransfer = new DataTransfer();
            for (var i = 0; i < storedFiles.length; i++)
                dataTransfer.items.add(storedFiles[i]);
            filesInput.files=dataTransfer.files
        };
        div.appendChild(span);
        imagesList.appendChild(div);
    }
    const dataTransfer = new DataTransfer();
    for (var i = 0; i < storedFiles.length; i++)
        dataTransfer.items.add(storedFiles[i]);
    filesInput.files=dataTransfer.files
})

oldImagesSpan=document.getElementsByClassName("oldImages")
for(i=0;i<oldImagesSpan.length;i++){
    oldImagesSpan[i].addEventListener("click", function(){
        this.parentElement.remove();
        if(document.getElementById("images").childElementCount==0)
            document.getElementById("files").setAttribute("required", "required");
        else
            document.getElementById("files").removeAttribute("required");
    });
}


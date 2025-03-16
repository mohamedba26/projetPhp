function categoryClick(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("category").innerHTML =this.responseText;
    }
    var idElement=document.getElementById("id");
    if(idElement==null)
        xhttp.open("GET", "categoryList.php", true);
    xhttp.send();
    if(document.getElementById("category").style.display=="block")
        document.getElementById("category").style.display="none";
    else
        document.getElementById("category").style.display="block";
}
document.getElementById("categoriesDropdown").addEventListener("click", function(){categoryClick()});
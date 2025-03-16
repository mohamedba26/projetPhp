document.getElementById("form").addEventListener("submit", function (event) {
    if (document.getElementById("password").value === document.getElementById("verif").value) {
        return true;
    } else {
        alert("password must be equal to verify password");
        event.preventDefault();
        return false;
    }
});
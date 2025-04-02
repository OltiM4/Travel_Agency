
function validateLoginForm() {
   
    var email = document.forms["loginForm"]["email"].value;
    var password = document.forms["loginForm"]["password"].value;
    var isValid = true;

    if (email == "") {
        document.getElementById('erroremail').innerHTML = "Ju lutemi vendosni adresën tuaj të email-it";
        isValid = false;
    } 
   
    else if (email.indexOf("@", 0) < 0) {
        document.getElementById('erroremail').innerHTML = "Ju lutemi vendosni një adresë të vlefshme email-i";
        isValid = false;
    } else {
        document.getElementById('erroremail').innerHTML = "";
    }

   
    if (password == "") {
        document.getElementById('errorpassword').innerHTML = "Ju lutemi vendosni fjalëkalimin tuaj";
        isValid = false;
    } else {
        document.getElementById('errorpassword').innerHTML = "";
    }

  
    return isValid;
}

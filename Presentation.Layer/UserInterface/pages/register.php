<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css"> 
</head>
<body>

    <main>
        <div class="formStyle">
            <p id="registerForm">Register</p> 
            <form action="../../../DataAccess.Layer/Config/cRegister.php" name="myForm" onsubmit="return validateFormRegister()" method="post"> 
                <label for="name" class="arrangeLabel" id="pak1">Name: </label><br> 
                <input type="text" placeholder="Enter name..." name="name"><br> 
                <span class="error" id="errorname"></span><br>

                <label for="surname" class="arrangeLabel" id="pak2">Surname: </label><br> 
                <input type="text" placeholder="Enter surname..." name="surname"><br>
                <span class="error" id="errorsurname"></span><br> 

                <label for="email" class="arrangeLabel" id="pak3">Email: </label><br> 
                <input type="email" placeholder="Enter email..." name="email"><br> 
                <span class="error" id="erroremail"></span><br> 

                <label for="password" class="arrangeLabel" id="pak4">Password: </label><br> 
                <input type="password" placeholder="Enter password..." name="password"><br>  
                <span class="error" id="errorpassword"></span><br> 
                <p id="dont">You already have an account? <a href="login.php"> Login here </a></p> 
                <input type="submit" value="Register" id="dnButt"><br> 
                <p><a href="index.php"> Go back </a></p> 
            </form>
        </div>
    </main>

    <script src="../js/register.js"></script> 
</body>
</html>

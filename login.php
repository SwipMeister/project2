<?php

include 'db.php';
include 'helper.php';

$gebruikersnaam = $password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

    // array for fieldnames
    $fieldnames = ['gebruikersnaam', 'password'];

    // helper class instantieren
    $validator = new Helper();
    // functie field_validator aanroepen en in een variabele gezet zodat hier later mee gewerkt kan worden
    $fields_are_validated = $validator->field_validator($fieldnames);

    // if field_validation returns TRUE -> set $_POST variabelen

    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $password = trim($_POST['password']);

    // database instantieren
    $db = new Database('localhost', 'project2', 'root', '',  'utf8');
      
    // function login (db.php) heeft error messages voor beide error voor beide scenarios
    $loginStatus = $db->login($gebruikersnaam, $password);


}


?>

<html>
    
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Log in!</title>
</head>
<style>
        body{
            background-color: #EFE8AA;
        }
    </style>

<body>
<div align="center">
        <a class="btn btn-primary" href="index.php">Home</a>
        <a class="btn btn-primary" href="signup.php">Aanmelden</a>
        <a class="btn btn-primary" href="login.php">Log in</a>
    </div>
<fieldset>
    <form align="center" action="login.php" method="post" id="login">
        <h3>Login</h3>
        <span class="text-danger"><?php echo (!empty($loginStatus) && $loginStatus != '') ? $loginStatus ."<br>": ''  ?></span>
                <label for="gebruikersnaam">Gebruikersnaam:</label><br> <!-- required="required"-->
                <input required type="text" name="gebruikersnaam" id="gebruikersnaam" pattern="[a-z]{1,15}+@"    ><br> <!-- required="required"-->
                <label for="password" >Password:</label><br>
                <input required type="password" name="password" id="password" minlength="10" maxlength="20">
                <br><br>
                <button class="btn btn-primary" type="submit" name="login" value="Login">Login</button><br    >
            </form>
        </fieldset>
    <div align="center">
        <a class="btn btn-primary" href="signup.php">Aanmelden</a>
    </div>
</body>

</html>
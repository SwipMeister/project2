<?php

include 'db.php';
include 'helper.php';

$voorletters = $voorvoegsels = $achternaam = $gebruikersnaam = $password = $pwFail = $msg = $pwSuccess =  '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['register']))) {

    $fieldnames = ['voorletters', 'voorvoegsels', 'achternaam', 'gebruikersnaam', 'password' ];
    // default error value to fix error msgs
    $error = False; // 0

    // new obj
    $val = new Helper();

    // field_validator from helperclass helping out with validation
    $fields_are_validated = $val->field_validator($fieldnames);


    if ($fields_are_validated) {
        // trim inputs

        $gebruikersnaam = trim(strtolower($_POST['gebruikersnaam']));
        $password = trim(strtolower($_POST['password']));

        $voorletters = trim(strtolower($_POST['voorletters']));
        $voorvoegsels = isset($_POST['voorvoegsels']) ? trim(strtolower($_POST['voorvoegsels'])) : NULL;    
        $achternaam = trim(strtolower($_POST['achternaam']));
        $repassword = trim(strtolower($_POST['repassword']));
        
        if ($_POST["password"] === $_POST["repassword"]) {

            // database instantieren
            $db = new Database('localhost', 'project2', 'root', '',  'utf8');
            
            // $db::USER pakt USER (2) constant uit db.php 
            
            $msg = $db->create_account($voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $password);
            // $account_id = $db->alterAccount($username, $email, $password);
            // $db->alterPersoon($voornaam, $tussenvoegsel, $achternaam, $email, $account_id);
            
            
          }else {
              // error message in variabele die naast het herhaalde password field plaatsvind
              $pwFail = "Wachtwoorden komen niet overeen. Vul opnieuw je wachtwoord in";
  
              $error = True;
  
            } 
          }


    }







?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Signupform</title>
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
  <form align="center" action="signup.php" method="post">
    <h3>Sign-up</h3>
                <label for="voorletters">Voorletters:</label><br>
                <input required type="text" name="voorletters" id="voorletters" value="<?php echo isset($_POST['voorletters']) ? htmlentities($_POST['voorletters']) : ''; ?>" ><span class="text-danger">*</span><br>
                <label for="voorvoegsels" >Voorvoegsels:</label><br>
                <input type="text" name="voorvoegsels" id="voorvoegsels" value="<?php echo isset($_POST['voorvoegsels']) ? htmlentities($_POST['voorvoegsels']) : ''; ?>"><br>
                <label for="achternaam" >Achternaam:</label><br>
                <input required type="text" name="achternaam" id="achternaam" value="<?php echo isset($_POST['achternaam']) ? htmlentities($_POST['achternaam']) : ''; ?>"><span class="text-danger">*</span><br>
                <label for="gebruikersnaam">Gebruikersnaam:</label><br>
                <input required pattern="[a-z]{1,15}+@" type="text"  name="gebruikersnaam" id="gebruikersnaam" value="<?php echo isset($_POST['gebruikersnaam']) ? htmlentities($_POST['gebruikersnaam']) : ''; ?>"><span class="text-danger">*</span><br>
                <label for="password" >Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="password" id="password"><span class="text-danger">*</span><br>
                <label for="repassword" >Repeat Password:</label><br>
                <input required minlength="10" maxlength="20" type="password" name="repassword" id="password"> <span class="text-danger">*<?php // if($pwFail) echo $pwFail;?></span><br>
                <br><span class="text-success"><?php  if($msg) echo $msg; ?></span>
                <br><span class="text-success"><?php if($pwSuccess) echo $pwSuccess; ?></span>
                <button class="btn btn-primary" type="submit" name="register" value="Register">Register</button><br>
                <a class="btn btn-primary" href="index.php">Terug naar het begin</a>
    </form> 
</fieldset>
</body>

</html>
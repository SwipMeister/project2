<?php

include 'db.php';

session_start();
// zorgt ervoor dat pagina niet via URL te vinden is. 
// WORKS
if(isset($_SESSION['gebruikersnaam']) && $_SESSION['gebruikersnaam'] == true){

    $_SESSION['loggedin'] = true;

}else {
    echo 'U bent niet ingelogd.';

    header("refresh:3;url=index.php");
    exit;
}
?>

<html>
    
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Log in!</title>
    <style>
        body{
            background-color: #EFE8AA;
        }
    </style>
</head>

<body>    
    <div align="center" >
        <a class="btn btn-primary" href="welcome.php">Home</a>
        <a class="btn btn-primary" href="new_product.php">Add product</a>
        <a class="btn btn-primary" href="delete_product.php">Edit or delete product</a>
        <a class="btn btn-primary" href="delete_fabriek.php">Edit or delete fabriek</a>
        <a class="btn btn-primary" href="voorraad.php">Overzicht voorraad</a>
        <a class="btn btn-primary" href="logout.php">Logout</a>
        <span class="btn btn-secondary">Ingelogd als: <?= $_SESSION['gebruikersnaam'];  ?></span>
    </div>


</body>

</html>
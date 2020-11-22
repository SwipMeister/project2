<?php

include 'db.php';
include 'helper.php';

session_start();
// zorgt ervoor dat pagina niet via URL te vinden is. 
// WORKS
if(isset($_SESSION['gebruikersnaam']) && $_SESSION['gebruikersnaam'] == true){

    $_SESSION['loggedin'] = true;

}else {
    echo 'U bent niet ingelogd.';

    header("refresh:3;url=login.php");
    exit;
}

$val = new Helper();
$db = new Database('localhost', 'project2', 'root', '',  'utf8');
// $productcode, $product, $type, $fabriekscode, $inkoopprijs,	$verkoopprijs
if ($_SERVER["REQUEST_METHOD"] == "POST" &&  (isset($_POST['add_product']))) {
    echo 'check';
    // sleep(3);
    print_r($_POST);

    $fieldnames = ['product', 'type', 'fabriekscode', 'inkoopprijs', 'verkoopprijs']; // password is optional
    
    $fields_are_validated = $val->field_validator($fieldnames);
    
    // functie field_validator returnt een true of false
    // if true --> sla user value op in $_POST variabelen
    if ($fields_are_validated) {
        
        // admin/user (1/2)
        $type =trim(strtolower($_POST['type']));
        
        //inputs trimmen naar lowercase
        $product = trim(strtolower($_POST['product']));
        $type = trim(strtolower($_POST['type']));
        $fabriekscode = $_POST['fabriekscode'];
        
        $inkoopprijs = trim(strtolower($_POST['inkoopprijs']));
        $verkoopprijs = trim(strtolower($_POST['verkoopprijs']));
        

            // echo 'hallo';
            $msg = $db->add_new_product($product, $type, $fabriekscode, $inkoopprijs,	$verkoopprijs);
            
            echo $msg;
        }
        
    }
    // fill option dynamically OPTIONAL
    // $option_fabriek_filler = $db->get_fabriek_details(null);
    // var_dump($option_fabriek_filler);


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
<div align="center" >
        <a class="btn btn-primary" href="welcome.php">Home</a>
        <a class="btn btn-primary" href="new_product.php">Add product</a>
        <a class="btn btn-primary" href="delete_product.php">Edit or delete product</a>
        <a class="btn btn-primary" href="delete_fabriek.php">Edit or delete fabriek</a>
        <a class="btn btn-primary" href="voorraad.php">Overzicht voorraad</a>
        <a class="btn btn-primary" href="logout.php">Logout</a>
        <span class="btn btn-secondary">Ingelogd als: <?= $_SESSION['gebruikersnaam'];  ?></span>
    </div>

<fieldset>
  <form align="center" action="new_product.php" method="post">
    <h3>Add new product</h3>
                <label for="product">Productnaam:</label><br>
                <input required type="text" name="product" id="product" value="<?php echo isset($_POST['product']) ? htmlentities($_POST['product']) : ''; ?>" ><span class="text-danger">*</span><br>
                <label for="type" >Product type:</label><br>
                <input type="text" name="type" id="type" value="<?php echo isset($_POST['type']) ? htmlentities($_POST['type']) : ''; ?>"><br>
                <div class="dropdown">
                <label for="fabriekscode">Fabriekscode:</label><br>
                    <select name='fabriekscode' id='fabriekscode'>
                        <option value=1>Worx</option>
                        <option value=2>Black & Decker</option>
                        <option value=3>Einhell</option>
                        <option value=4>Kracher</option>
                        <option value=5>Bosch</option>
                        <option value=6>Sencys</option>
                    </select>
                </div><br>
                <label for="inkoopprijs" >Inkoopprijs:</label><br>
                <input required type="text" name="inkoopprijs" id="inkoopprijs" value="<?php echo isset($_POST['inkoopprijs']) ? htmlentities($_POST['inkoopprijs']) : ''; ?>"><span class="text-danger">*</span><br>
                <label for="verkoopprijs" >Verkoopprijs:</label><br>
                <input required type="text" name="verkoopprijs" id="verkoopprijs" value="<?php echo isset($_POST['verkoopprijs']) ? htmlentities($_POST['verkoopprijs']) : ''; ?>"><span class="text-danger">*</span><br>
               


                <br><span class="text-success"></span>
                <br><span class="text-success"></span>
                <button class="btn btn-primary" type="submit" name="add_product" value="Add product">Add product</button>
                <a class="btn btn-primary" href="welcome.php">Terug naar het begin</a>
    </form> 
</fieldset>



</body>

</html>
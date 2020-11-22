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
$msg = $msg_update = '';
$db = new Database('localhost', 'project2', 'root', '',  'utf8');
$val = new Helper();
// $productcode, $product, $type, $fabriekscode, $inkoopprijs,	$verkoopprijs
// if ($_SERVER["REQUEST_METHOD"] == "POST" &&  (isset($_POST['add_product']))) {
//     echo 'check';
//     // sleep(3);
//     print_r($_POST);

//     $fieldnames = ['product', 'type', 'fabriekscode', 'inkoopprijs', 'verkoopprijs']; // password is optional
    
//     $fields_are_validated = $val->field_validator($fieldnames);
    
//     // functie field_validator returnt een true of false
//     // if true --> sla user value op in $_POST variabelen
//     if ($fields_are_validated) {
        
//         // admin/user (1/2)
//         $type =trim(strtolower($_POST['type']));
        
//         //inputs trimmen naar lowercase
//         $product = trim(strtolower($_POST['product']));
//         $type = trim(strtolower($_POST['type']));
//         $fabriekscode = $_POST['fabriekscode'];
        
//         $inkoopprijs = trim(strtolower($_POST['inkoopprijs']));
//         $verkoopprijs = trim(strtolower($_POST['verkoopprijs']));
        

//             echo 'hallo';
//             $msg = $db->add_new_product($product, $type, $fabriekscode, $inkoopprijs,	$verkoopprijs);
            
//             echo $msg;
//         }

//     }     


    if (isset($_GET['edit'])) {
        $productcode = $_GET['edit'];
        $artikel_update_true = true;
        echo $productcode;
        $artikel_details = $db->get_product_details($productcode);
        $productcode = $artikel_details['productcode'];
        $product = $artikel_details['product'];
        $type = $artikel_details['type'];
        $fabriekscode = $artikel_details['fabriekscode'];
        $inkoopprijs = $artikel_details['inkoopprijs'];
        $verkoopprijs = $artikel_details['verkoopprijs'];
        // echo $product;
        print_r($artikel_details);
        
        
    }
    
    
    // $msg_update = $db->alterArtikel($artikel);
    
    
    // if ($artikel_update_true) {
        //     echo 'edit';
        // }
        
        // header("refresh:1;url=delete_product.php");
        
        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" &&  count($_POST) > 0) {
            echo 'post check';
            
        echo '<br>';
        print_r($_POST);
        // $productcode = $_GET['edit'];
        // echo $productcode;
        $fieldnames = [ 'product', 'type', 'fabriekscode', 'inkoopprijs', 'verkoopprijs'];

        $fields_are_validated = $val->field_validator($fieldnames);
        // returnt true or false

        if ($fields_are_validated) {
            
            //inputs trimmen naar lowercase
            $productcode = $_POST['productcode'];
            $product = trim(strtolower($_POST['product']));
            $type = trim(strtolower($_POST['type']));
            $fabriekscode = trim(strtolower($_POST['fabriekscode']));
            $inkoopprijs = trim(strtolower($_POST['inkoopprijs']));
            $verkoopprijs = trim(strtolower($_POST['verkoopprijs']));
            echo 'updating';

            
                // echo $artikel_update_true;
                $artikel = [
                    'productcode' => $_POST['productcode'],
                    'product' => $_POST['product'],
                    'type' => $_POST['type'],
                    'fabriekscode' => $_POST['fabriekscode'],
                    'inkoopprijs' => $_POST['inkoopprijs'],
                    'verkoopprijs' => $_POST['verkoopprijs']
                ];
                // print_r($artikel);
                
                
            }
            $db->alterArtikel($artikel);
            
        }


    


?>


<html>
    
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Edit product</title>
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
    <form align="center" action="edit_product.php" method="post">
        <input type="hidden" name="edit" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">

    <h3>Edit product</h3>
                <label for="productcode">Productcode:</label><br>
                <input readonly type="text" name="productcode" id="productcode" value="<?php echo $productcode; ?>"><span class="text-danger">*</span><br>
                <label for="product">Productnaam:</label><br>
                <input required type="text" name="product" id="product" value="<?php echo $product; ?>"><span class="text-danger">*</span><br>
                <label for="type" >Product type:</label><br>
                <input type="text" name="type" id="type" value="<?php echo $type; ?>"><br>
                <div class="dropdown">
                <label for="fabriekscode">Fabriekscode:</label><br>
                    <select name='fabriekscode' id='fabriekscode'>
                        <option <?php if($fabriekscode == 1){ ?> selected <?php }else { echo '';} ?> value=1>Worx</option>
                        <option <?php if($fabriekscode == 2){ ?> selected <?php }else { echo '';} ?> value=2>Black & Decker</option>
                        <option <?php if($fabriekscode == 3){ ?> selected <?php }else { echo '';} ?> value=3>Einhell</option>
                        <option <?php if($fabriekscode == 4){ ?> selected <?php }else { echo '';} ?> value=4>Kracher</option>
                        <option <?php if($fabriekscode == 5){ ?> selected <?php }else { echo '';} ?> value=5>Bosch</option>
                        <option <?php if($fabriekscode == 6){ ?> selected <?php }else { echo '';} ?> value=6>Sencys</option>
                    </select>
                </div><br>
                <label for="inkoopprijs" >Inkoopprijs:</label><br>
                <input required type="text" name="inkoopprijs" id="inkoopprijs" value="<?php echo $inkoopprijs; ?>"><span class="text-danger">*</span><br>
                <label for="verkoopprijs" >Verkoopprijs:</label><br>
                <input required type="text" name="verkoopprijs" id="verkoopprijs" value="<?php echo $verkoopprijs; ?>"><span class="text-danger">*</span><br>
               


                <br><span class="text-success"><?php if($msg) echo $msg; ?></span>
                <br><span class="text-success"><?php if($msg_update) echo $msg_update; ?></span>
                <button class="btn btn-primary" type="submit" name="edit" value="edit_product">Edit product</button>
                <a class="btn btn-primary" href="welcome.php">Terug naar het begin</a>
    </form> 
</fieldset>



</body>

</html>
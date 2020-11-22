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
// $fabriekscode, $product, $type, $fabriekscode, $inkoopprijs,	$verkoopprijs
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
        $fabriekscode = $_GET['edit'];
        $artikel_update_true = true;
        echo $fabriekscode;
        $fabriek_details = $db->get_fabriek_details($fabriekscode);
        $fabriekscode = $fabriek_details['fabriekscode'];
        $fabriek = $fabriek_details['fabriek'];
        $telefoon = $fabriek_details['telefoon'];
        // echo $product;
        print_r($fabriek_details);
        
        
    }
    
    
    // $msg_update = $db->alterArtikel($artikel);
    
    
    // if ($artikel_update_true) {
        //     echo 'edit';
        // }
        
        // header("refresh:1;url=delete_product.php");
        
        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" &&  count($_POST) > 0) {
            echo 'post check';
            
        echo '<br>';
        // print_r($_POST);
        // $fabriekscode = $_GET['edit'];
        // echo $fabriekscode;
        $fieldnames = ['fabriekscode', 'fabriek',  'telefoon'];

        $fields_are_validated = $val->field_validator($fieldnames);
        // returnt true or false

        if ($fields_are_validated) {
            
            //inputs trimmen naar lowercase
            $fabriekscode = $_POST['fabriekscode'];
            $fabriek = trim(strtolower($_POST['fabriek']));
            $telefoon = trim(strtolower($_POST['telefoon']));
            echo 'updating';

            
                // echo $artikel_update_true;
                $fabriekSet = [
                    'fabriekscode' => $_POST['fabriekscode'],
                    'fabriek' => $_POST['fabriek'],
                    'telefoon' => $_POST['telefoon']
   
                ];
                // print_r($fabriekSet);
                
                
            }
            $db->alterFabriek($fabriekSet);
            
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
    <form align="center" action="edit_fabriek.php" method="post">
        <input type="hidden" name="edit" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">

    <h3>Edit fabriek</h3>
                <label for="fabriekscode">Fabriekscode:</label><br>
                <input readonly type="text" name="fabriekscode" id="fabriekscode" value="<?php echo $fabriekscode; ?>"><span class="text-danger">*</span><br>
                <label for="fabriek">Fabrieksnaam:</label><br>
                <input required type="text" name="fabriek" id="fabriek" value="<?php echo $fabriek; ?>"><span class="text-danger">*</span><br>
                <label for="telefoon" >Telefoon:</label><br>
                <input type="text" name="telefoon" id="telefoon" value="<?php echo $telefoon; ?>"><br>
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

                <br><span class="text-success"><?php if($msg) echo $msg; ?></span>
                <br><span class="text-success"><?php if($msg_update) echo $msg_update; ?></span>
                <button class="btn btn-primary" type="submit" name="edit" value="edit_fabriek">Edit fabriek</button>
                <a class="btn btn-primary" href="welcome.php">Terug naar het begin</a>
    </form> 
</fieldset>



</body>

</html>
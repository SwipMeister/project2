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
$db = new Database('localhost', 'project2', 'root', '',  'utf8');



$result_voorraad_set = $db->get_voorraad_details();
// print_r($result_voorraad_set);

$columns = array_keys($result_voorraad_set[0]);





?>

<html>
    
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Voorraad</title>
    <style>
        body{
            background-color: #EFE8AA;
            
        }
        .table-responsive{
            overflow-x: unset !important;
        }
    </style>
</head>

<body>    
    <div align="center">
        <a class="btn btn-primary" href="welcome.php">Home</a>
        <a class="btn btn-primary" href="new_product.php">Add product</a>
        <a class="btn btn-primary" href="delete_product.php">Edit or delete product</a>
        <a class="btn btn-primary" href="delete_fabriek.php">Edit or delete fabriek</a>
        <a class="btn btn-primary" href="voorraad.php">Overzicht voorraad</a>
        <a class="btn btn-primary" href="logout.php">Logout</a>
        <span class="btn btn-secondary">Ingelogd als: <?= $_SESSION['gebruikersnaam'];  ?></span>
    </div>

    <div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Overzicht voorraad</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <?php foreach ($columns as $column) { 
                                
                          echo  "<th> $column </th>";
                             } ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php // loop de resultset en zet ze als row met id zodat er een nieuwe aangemaakt wordt ?>
                        <?php  foreach ($result_voorraad_set as $rows => $row) { ?>

                            
                            
                    <tr>
                                
                        <?php // loop de rows  ?>
                        <?php  foreach ($row as $user_data) { ?>
    
    
                           <td> <?php echo $user_data; ?> </td>
                           <?php  } ?>
                           
                           
                      </tr>
                           <?php    }?>

                </tbody>
            </table>
        </div>
    </div>
</div>   
</body>

</html>
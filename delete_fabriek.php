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


if (isset($_GET['del'])) {
    $fabriekscode = $_GET['del'];
    echo $fabriekscode;
    
    $db->dropFabriek($fabriekscode);
    header("refresh:1;url=delete_fabriek.php");

}


$result_artikel_set = $db->get_fabriek_details(null);
// print_r($result_artikel_set);

$columns = array_keys($result_artikel_set[0]);





?>

<html>
    
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Edit/Delete</title>
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
                        <h2>Edit or delete fabriek</b></h2>
                        <p>NOTE: Een fabriek kan pas verwijderd worden wanneer de producten niet meer gekoppeld zijn. Wijzig dus eerst je artikelen!</p>

                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <?php foreach ($columns as $column) { 
                                
                          echo  "<th> $column </th>";
                             } ?>
                                <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php // loop de resultset en zet ze als row met id zodat er een nieuwe aangemaakt wordt ?>
                        <?php  foreach ($result_artikel_set as $rows => $row) { ?>
                            <?php $row_id = $row['fabriekscode']; ?>
                            <?php $row_name = $row['fabriek']; ?>
                            
                            
                    <tr>
                                
                        <?php // loop de rows  ?>
                        <?php  foreach ($row as $user_data) { ?>
    
    
                           <td> <?php echo $user_data; ?> </td>
                           <?php  } ?>
                           
                           
                           <td><a href="edit_fabriek.php?edit=<?php echo $row_id; ?>" class="btn btn-primary">Edit</a></td>
                           <td><a href="delete_fabriek.php?del=<?php echo $row_id; ?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                           <?php    }?>

                </tbody>
            </table>
        </div>
    </div>
</div>   
</body>

</html>
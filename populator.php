<?php

include 'db.php';


$db = new Database('localhost', 'project2', 'root', '',  'utf8');
$fabrieken = ['Worx', 'Black & Decker', 'Einhell', 'Kracher', 'Bosch', 'Sencys',];

foreach ($fabrieken as $fabriek) {
    $db->insertFabriek($fabriek, '0612345678');
}


<?php 

class Database {

    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $db;

    // const Worx = 1;
    // const BlackDecker = 2;
    // const Einhell = 3;
    // const Kracher = 4;
    // const Bosch = 5;
    // const Sencys = 6;


    public function __construct($host, $db_name, $username, $password, $charset)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;

        try {
            // data source name
            $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset";
            $this->db = new PDO($dsn, $this->username, $this->password);
            // echo "Database connection succesfully established <br>" ;

        } catch (PDOException $e) {

            // die met error message
            die("An error occured" . $e->getMessage());
        }

    }



    public function create_account($voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $password){

        try {
            //start transactie
            $this->db->beginTransaction();

            // check of het een bestaande gebruiker is met functie new_account_check
            // NIET false dus TRUE betekent user bestaat
            // if (!$this->new_account_check($username)) {
            //     return "Username al in gebruik, kies een andere username.";
            // }

            // password hashen
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            //$voorletters, $voorvoegsels, $achternaam, $gebruikersnaam, $password
            $sql = "INSERT INTO medewerkers VALUES (NULL, :voorletters, :voorvoegsels, :achternaam, :gebruikersnaam, :password)"; // replacement fields
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute(['voorletters' => $voorletters, 'voorvoegsels' => $voorvoegsels, 'achternaam' => $achternaam, 'gebruikersnaam' => $gebruikersnaam, 'password' => $hashPassword]);
            
            // commit database change
            $this->db->commit();

            // if(isset($_SESSION) && $_SESSION['type'] == self::ADMIN){
            //     return "Nieuwe gebruiker toegevoegd.";
            // }
            echo '<h3 align="center">Registratie voltooid. U wordt doorverwezen naar de login</h3>';
            header("refresh:3;url=login.php");
            // exit makes sure that further code isn't executed.
            exit;
            
            


        } catch (Exception $e) {
            // rollback database changes in case of an error to maintain data integrity.
            $this->db->rollback();
            echo "Signup failed: " . $e->getMessage();
        }

    }

    public function login($gebruikersnaam, $password){
        // id, type, password opvragen van :gebruikersnaam, dit is de gebruikersnaam die de user invult
        $sql = "SELECT medewerkerscode, password FROM medewerkers WHERE gebruikersnaam = :gebruikersnaam";

        // query preparen en executen
        $stmt = $this->db->prepare($sql);

        // execute 
        $stmt->execute(['gebruikersnaam'=>$gebruikersnaam]);
        
        // Resultaat van fetch() in var stoppen -> array
        $result = $stmt->fetch();
    //  var_dump($result);

        // check if $result is array
        if (is_array($result) && count($result) > 0) {

            // double check of $result een arrau heeft
            //  print_r( $result);
                // echo "<br>";
    
                // gehashte password in var zetten om te checken met password_verify
                $hashed_pw = $result['password'];

                // var_dump password_verify om te kijken of t ingevulde wachtwoord overeenkomt met de hash
                // var_dump(password_verify($password, $hashed_pw));
                // echo "<br>";

                // check if user exists and if passwords match
                if ($gebruikersnaam && password_verify($password, $hashed_pw)) {

                    session_start();
                    // userdate opslaan in session variables
                    $_SESSION['id'] = $result['medewerkerscode'];
                    $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                    // $_SESSION['usertype'] = $result['type']; add to $sql when usertype is fixed
                    $_SESSION['loggedin'] = true;
                    echo 'U bent nu ingelogd';
                    header("refresh:3;url=welcome.php"); 
                    exit;


                }else {
                    // als de gebruikersnaam en password niet overeenkomen print:
                    return 'Username en/of password zijn verkeerd, probeer opnieuw';
                }
            

        }else{
            // no matching user found in db. Make sure not to tell the user.
            return "Inloggen mislukt, probeer opnieuw.";
        }



}

public function insertFabriek($fabriek, $telefoon){
    try {
        //start transactie
        $this->db->beginTransaction();

        //$fabriekscode, $fabriek, $telefoon
        $sql = "INSERT INTO fabriek VALUES (NULL, :fabriek, :telefoon)"; // replacement fields
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute(['fabriek' => $fabriek, 'telefoon' => $telefoon]);
        
        // commit database change
        $this->db->commit();

        // exit makes sure that further code isn't executed.
        exit;

    } catch (Exception $e) {
        // rollback database changes in case of an error to maintain data integrity.
        $this->db->rollback();
        echo "Signup failed: " . $e->getMessage();
    }

}

public function add_new_product($product, $type, $fabriekscode, $inkoopprijs, $verkoopprijs){
    try {
        //start transactie
        $this->db->beginTransaction();

        //	$productcode, $product, $type, $fabriekscode, $inkoopprijs,	$verkoopprijs
        $sql = "INSERT INTO artikel VALUES (NULL, :product, :type, :fabriekscode, :inkoopprijs, :verkoopprijs)"; // replacement fields
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute(['product' => $product, 'type' => $type, 'fabriekscode' => $fabriekscode, 'inkoopprijs' => $inkoopprijs, 'verkoopprijs' => $verkoopprijs]);
        
        // commit database change
        $this->db->commit();

        echo '<h3 align="center">Product toegevoegd.</h3>';
        header("refresh:3;url=new_product.php");
        // exit makes sure that further code isn't executed.
        exit;
        
    } catch (Exception $e) {
        // rollback database changes in case of an error to maintain data integrity.
        $this->db->rollback();
        echo "Signup failed: " . $e->getMessage();
    }

}

// ---------------------------- ARTIKEL FUNCTIONS

public function get_product_details($productcode){
    // get everything from artikel
    $sql = "SELECT * FROM artikel ";
    if ($productcode > 0) {
        $sql .= "WHERE productcode = :productcode";
        $statement = $this->db->prepare($sql);
        $statement->execute(['productcode'=>$productcode]);
        $artikel = $statement->fetch(PDO::FETCH_ASSOC);
        return $artikel;
    }else{
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $artikel = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $artikel;

    }

}

public function alterArtikel($product_details) {

    if(is_array($product_details)){

    $productcode = $product_details['productcode'];
    // print_r ($product_details); 
    $product = $product_details['product'];
    $type = $product_details['type'];
    $fabriekscode = $product_details['fabriekscode'];
    $inkoopprijs = $product_details['inkoopprijs'];
    $verkoopprijs = $product_details['verkoopprijs'];
    
    $sql = "UPDATE artikel SET product = :product, type = :type, fabriekscode = :fabriekscode, inkoopprijs = :inkoopprijs, verkoopprijs = :verkoopprijs WHERE productcode = :productcode";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['productcode'=>$productcode, 'product'=>$product, 'type'=>$type, 'fabriekscode'=>$fabriekscode, 'inkoopprijs'=>$inkoopprijs, 'verkoopprijs'=>$verkoopprijs]);
    echo  'Artikel updated';
    header("refresh:3;url=delete_product.php");

    }else{

        // return string error msg
        return 'artikelset is geen array';
    }

}

public function dropArtikel($productcode){

    // standard try catch
    try{
        $this->db->beginTransaction();
        $stmt = $this->db->prepare("DELETE FROM artikel WHERE productcode=:productcode");
        $stmt->execute(['productcode'=>$productcode]);

        $this->db->commit();

        return  'Rij verwijdered.';

    }catch(Exception $e){
        $this->db->rollback();
        echo 'Error: '.$e->getMessage();
    }
}
// ---------------------------- FABRIEK FUNCTIONS


public function get_fabriek_details($fabriekscode){
    // get everything from artikel
    $sql = "SELECT * FROM fabriek ";
    if (!is_null($fabriekscode)) {
        $sql .= "WHERE fabriekscode = :fabriekscode";
        $statement = $this->db->prepare($sql);
        $statement->execute(['fabriekscode'=>$fabriekscode]);
        $fabriek = $statement->fetch(PDO::FETCH_ASSOC);
        return $fabriek;
    }else{
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $fabriek = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $fabriek;

    }

}

public function alterFabriek($fabriek_details) {

    if(is_array($fabriek_details)){

        $fabriekscode = $fabriek_details['fabriekscode'];
        $fabriek = $fabriek_details['fabriek'];
        $telefoon = $fabriek_details['telefoon'];
        // print_r ($fabriek_details); 

        
        $sql = "UPDATE fabriek SET fabriek = :fabriek, telefoon = :telefoon WHERE fabriekscode = :fabriekscode";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['fabriekscode'=>$fabriekscode, 'fabriek'=>$fabriek, 'telefoon'=>$telefoon]);
        echo  'Fabriek updated';
        header("refresh:3;url=delete_fabriek.php");
    
        }else{
    
            // return string error msg
            return 'artikelset is geen array';
        }

}

public function dropFabriek($fabriekscode){

    try{
        $this->db->beginTransaction();
        $stmt = $this->db->prepare("DELETE FROM fabriek WHERE fabriekscode=:fabriekscode");
        $stmt->execute(['fabriekscode'=>$fabriekscode]);

        $this->db->commit();

        return  'Fabriek verwijdered.';

    }catch(Exception $e){
        $this->db->rollback();
        echo 'Error: '.$e->getMessage();
    }

}


public function get_voorraad_details(){

    $sql = "SELECT * FROM voorraad ";
    // try to get user friendly names but gave up massive brainfart
    // $sql2 = "SELECT * FROM voorraad as v LEFT JOIN artikel as a ON v.productcode = a.productcode INNER JOIN locatie as l ON v.locatiecode = l.locatiecode";
    $statement = $this->db->prepare($sql);
    $statement->execute();
    $fabriek = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $fabriek;

    

    
}


}

// try{
            
//     // start transactie
//     $this->db->beginTransaction();
//     // set variables
//     $productcode = $product_details['productcode'];
//     print_r ($product_details);
//     $product = $product_details['product'];
//     $type = $product_details['type'];
//     $fabriekscode = $product_details['fabriekscode'];
//     $inkoopprijs = $product_details['inkoopprijs'];
//     echo  'meh';
//     $verkoopprijs = $product_details['verkoopprijs'];
    
//     $sql = "UPDATE artikel SET product = :product, type = :type, fabriekscode = :fabriekscode, inkoopprijs = :inkoopprijs, verkoopprijs = :verkoopprijs WHERE productcode = :productcode";

//     $statement = $this->db->prepare($sql);

//     $statement->execute(['productcode'=> $productcode, 'product'=>$product, 'type'=> $type, 'fabriekscode'=> $fabriekscode, 'inkoopprijs'=> $inkoopprijs, 'verkoopprijs'=> $verkoopprijs]);

//     // commit database change
//     $this->db->commit();
    
//     // header("refresh:3;url=delete_product.php");
//     return 'User data succesfully updated';
// }catch(Exception $e){
//     $this->db->rollback();
//     echo 'Error occurred: '.$e->getMessage();
// }
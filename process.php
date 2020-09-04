<?php
//registreren.php
$host = "localhost";
$username = "root";
$password = "";
$database = "login-system";

try {
    $connect = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO users (voornaam, tussenvoegsel, achternaam, email, username, wachtwoord) VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :username, :wachtwoord)";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            'voornaam' => $_POST["voornaam"],
            'tussenvoegsel' => $_POST["tussenvoegsel"],
            'achternaam' => $_POST["achternaam"],
            'email' => $_POST["email"],
            'username' => $_POST["username"],
            'wachtwoord' => $_POST["wachtwoord"]
        )
    );
    header("location:index.php");
  } 
  catch(PDOException $e) {
    echo $query . "<br>" . $e->getMessage();
  }
  
  $connect = null;

?>
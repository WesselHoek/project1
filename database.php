<?php
// database.php
class DB{
    private $host;
    private $user;
    private $pass;
    private $name;
    private $charset;

    private $db;
    private $stmt;
    private $resultSet;

    public function __construct($host, $user, $pass, $name, $charset){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->charset = $charset;

        try{
            $dsn = "mysql:host=$this->host; dbname=$this->name; charset=$this->charset";
            $this->db = new PDO($dsn, $this->user, $this->pass);
            $this->resultSet = [];
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            echo $error->getMessage();
            exit("An error occured");
        }
    }

    public function execute()
    {
        try {
            $query1 = "INSERT INTO account (email, password) VALUES (:email, :wachtwoord)";
            $query2 = "INSERT INTO persoon (voornaam, tussenvoegsel, achternaam, username) VALUES (:voornaam, :tussenvoegsel, :achternaam, :username)";
            $query3 = "UPDATE persoon SET account_id = (select id from account where email = :email)";

            $statement1 = $this->db->prepare($query1);
            $statement2 = $this->db->prepare($query2);
            $statement3 = $this->db->prepare($query3);

            $statement1->execute(
                array(
                    'email' => $_POST["email"],
                    'wachtwoord' => $_POST["wachtwoord"]
                )
            );

            $statement2->execute(
                array(
                    'voornaam' => $_POST["voornaam"],
                    'tussenvoegsel' => $_POST["tussenvoegsel"],
                    'achternaam' => $_POST["achternaam"],
                    'username' => $_POST["username"]
                )
            );

            $statement3->execute(
                array(
                    'email' => $_POST["email"],
                )
            );
            
            header("location:index.php");

        } catch (PDOException $error) {
            echo $error->getMessage();
            exit("An error occured");
        }
    }

    public function login(){
        try {
            $query1 = "SELECT * FROM account where email = :email AND password = :password";
            $statement1 = $this->db->prepare($query1);
            $statement1->execute(
                array(
                    'email' => $_POST["email"],
                    'password' => $_POST["password"]
                )
            );

            $count = $statement1->rowCount();

            if ($count > 0) {
                $_SESSION["email"] = $_POST["email"];
                header("location: login_succes.php");
            } else {
                echo '<label>Verkeerd wachtwoord of username</label>';
            }
            
        } catch (PDOException $error) {
            echo $error->getMessage();
            exit("An error occured");
        }
    }
}

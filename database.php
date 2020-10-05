<?php
// database.php
class DB{
    private $host;
    private $user;
    private $pass;
    private $name;
    private $charset;

    private $db;
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

    public function execute($firstname, $tsv, $lastname, $email, $uname, $psw){
        try {
            $query1 = "INSERT INTO account (username, email, password, created, updated, usertype) VALUES (:username, :email, :wachtwoord, CURRENT_TIMESTAMP , CURRENT_TIMESTAMP, 1)";
            $statement1 = $this->db->prepare($query1);
            $statement1->execute(
                array(
                    'username' => $uname,
                    'email' => $email,
                    'wachtwoord' => password_hash($psw, PASSWORD_DEFAULT)
                )
            );

            $account_id = $this->db->lastInsertId();

            $query2 = "INSERT INTO persoon (voornaam, tussenvoegsel, achternaam, account_id, created, updated) VALUES (:voornaam, :tussenvoegsel, :achternaam, :account_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
            $statement2 = $this->db->prepare($query2);
            $statement2->execute(
                array(

                    'voornaam' => $firstname,
                    'tussenvoegsel' => $tsv,
                    'achternaam' => $lastname,
                    'account_id' => $account_id
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
            $gethash = "SELECT password FROM account WHERE email = :email";
            $statement2 = $this->db->prepare($gethash);

            $statement2->execute(
                array(
                    'email' => $_POST["email"]
                )
            );

            $result = $this->resultSet = $statement2->fetchAll(PDO::FETCH_ASSOC);
            $hash = $result[0]["password"];

            $query1 = "SELECT * FROM account where email = :email AND password = :password";
            $statement1 = $this->db->prepare($query1);
            $statement1->execute(
                array(
                    'email' => $_POST["email"],
                    'password' => $hash
                )
            );

            $count1 = $statement1->rowCount();
            
            if(password_verify($_POST["password"], $hash)) {
                echo "yes";
                print_r($count1);
                if ($count1 > 0) {
                    $_SESSION["email"] = $_POST["email"];
                    header("location:login_succes.php");
                } 
            }else {
                echo '<label>Verkeerd wachtwoord of username</label>';
            }
            
        } catch (PDOException $error) {
            echo $error->getMessage();
            exit("An error occured");
        }
    }
}

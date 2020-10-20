<?php
// database.php
class DB{
    private $host;
    private $user;
    private $pass;
    private $name;
    private $charset;

    protected $dbh;       // dit is de verbinding met de databas
    protected $stmt;      // dit is het huidige statement
    protected $resultSet; // hierin komen de resutlaten te staan van een query


    public function __construct($host, $user, $pass, $name, $charset){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->charset = $charset;

        try{
            $dsn = "mysql:host=$this->host; dbname=$this->name; charset=$this->charset";
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
            $this->resultSet = [];
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            echo $error->getMessage();
            exit("An error occured");
        }
    }

    public function execute($firstname, $tsv, $lastname, $email, $uname, $psw){
        try {
            $query1 = "INSERT INTO account (username, email, password, created, last_updated, usertype_id) VALUES (:username, :email, :wachtwoord, CURRENT_TIMESTAMP , CURRENT_TIMESTAMP, 1)";
            $statement1 = $this->dbh->prepare($query1);
            $statement1->execute(
                array(
                    'username' => $uname,
                    'email' => $email,
                    'wachtwoord' => password_hash($psw, PASSWORD_DEFAULT)
                )
            );

            $account_id = $this->dbh->lastInsertId();

            $query2 = "INSERT INTO persoon (voornaam, tussenvoegsel, achternaam, account_id, created, last_updated) VALUES (:voornaam, :tussenvoegsel, :achternaam, :account_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
            $statement2 = $this->dbh->prepare($query2);
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

    public function login($email){
        try {
            $gethash = "SELECT password FROM account WHERE email = :email";
            $statement2 = $this->dbh->prepare($gethash);
            $statement2->execute(
                array(
                    'email' => $email
                )
            );

            $result = $this->resultSet = $statement2->fetchAll(PDO::FETCH_ASSOC);
            $hash = $result[0]["password"];

            $query1 = "SELECT * FROM account where email = :email AND password = :password";
            $statement1 = $this->dbh->prepare($query1);
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

    // public function changeRole($role){
    //     $updateRole = "UPDATE account SET usertype = :role WHERE id = $currentID";
    //         $statement1 = $this->db->prepare($updateRole);
    //         $statement1->execute(
    //             array(
    //                 'role' => $role
    //             )
    //         );
    // }

    public function Read(){
        $this->stmt = $this->dbh->prepare("SELECT account_id,voornaam,tussenvoegsel,achternaam FROM persoon");
        $result = $this->stmt->execute();

        if (!$result) {
            die('<pre>Oops, Error execute query ' . $result . '</pre><br><pre>' . 'Result code: ' . $result . '</pre>');
        }

        $this->resultSet = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $stack = $this->resultSet;
        if ($stack == FALSE) {
            echo "Query is fout gegaan OF er zijn geen resultaten voor deze query!";
            } else {
            $count = count($stack);
            echo "<br>";
            for ($i = 0; $i < $count; $i++) {
                $show = array_shift($stack);
                echo "<tr>";
                foreach ($show as $key => $val) {
                    echo "<td>$val</td>";
                }
                echo "</tr>";
                echo "<br>";
            }
        }
    }

    public function ListForExcel(){
        $this->stmt = $this->dbh->prepare("SELECT account_id,voornaam,tussenvoegsel,achternaam FROM persoon");
        $result = $this->stmt->execute();

        if (!$result) {
            die('<pre>Oops, Error execute query ' . $result . '</pre><br><pre>' . 'Result code: ' . $result . '</pre>');
        }

        $this->resultSet = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $stack = $this->resultSet;
        return $stack;
    }
}

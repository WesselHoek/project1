<?php
//lost-password.php




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vergeten-Wachtwoord Pagina</title>

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
    <br>
    <?php
    if(isset($message))
    {
        echo '<label class="test-danger">'.$message.'</label>';
    }
    ?>
    <div class="container" style="width: 500px;">
        <h3>PHP Login Pagina</h3><br>
        <form action="" method="post">

            <p>Als je jouw wachtwoord vergeten bent, voer dan hier uw email in en dan sturen wij een mail met een link om uw wachtwoord te veranderen.</p>

            <label for="E-mail">E-mail</label>
            <input type="text" name="email" class="form-control">
            <br>

            <input type="submit" name="verstuur" class="btn btn-info" value="Verstuur">
            <button type="button" class="btn btn-link"><a href="signup.php">Registreren?</a></button>
            <button type="button" class="btn btn-link"><a href="index.php">Login?</a></button>
        </form>
    </div>
</body>
</html>
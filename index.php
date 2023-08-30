<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen en Registreren</title>
    <!-- Voeg hier eventuele stijlen toe -->
</head>
<body>
    <?php
    session_start();

    // Controleer of de gebruiker is ingelogd
    if (isset($_SESSION["username"])) {
        header("Location: startpagina.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Controleer de inloggegevens (dit is een eenvoudig voorbeeld)
            if (checkLogin($username, $password)) {
                $_SESSION["username"] = $username;
                header("Location: startpagina.php");
                exit();
            } else {
                echo "Ongeldige inloggegevens.";
            }
        } elseif (isset($_POST["register"])) {
            $newUsername = $_POST["new_username"];
            $newPassword = $_POST["new_password"];

            // Voeg de registratiegegevens toe (dit is een eenvoudig voorbeeld)
            registerUser($newUsername, $newPassword);
            echo "Account succesvol geregistreerd!";
        }
    }

    function checkLogin($username, $password) {
        // Hier zou je echte inlogvalidatie moeten uitvoeren, bijvoorbeeld met een database
        $users = file("accounts.txt", FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($storedUsername, $storedPassword) = explode(":", $user);
            if ($username === $storedUsername && $password === $storedPassword) {
                return true;
            }
        }
        return false;
    }

    function registerUser($username, $password) {
        // Hier zou je echte accountregistratie moeten uitvoeren, bijvoorbeeld met een database
        $userLine = $username . ":" . $password . "\n";
        $file = fopen("accounts.txt", "a");
        fwrite($file, $userLine);
        fclose($file);
    }
    ?>

    <h2>Inloggen</h2>
    <form action="" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="login" value="Inloggen">
    </form>

    <h2>Registreren</h2>
    <form action="" method="POST">
        <label for="new_username">Nieuwe gebruikersnaam:</label>
        <input type="text" id="new_username" name="new_username" required>
        <label for="new_password">Nieuw wachtwoord:</label>
        <input type="password" id="new_password" name="new_password" required>
        <input type="submit" name="register" value="Registreren">
    </form>
</body>
</html>

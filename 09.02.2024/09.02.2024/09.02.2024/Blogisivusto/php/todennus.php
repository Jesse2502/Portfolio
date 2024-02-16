<?php
session_start();
session_regenerate_id(true);

try {
    $connection = new PDO("mysql:host=localhost;dbname=blogi", "root", "");
} catch (PDOException $e) {
    die("ERROR" . $e->getMessage());
}

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->exec("SET NAMES utf8");

$query = $connection->prepare("SELECT * FROM kayttajat WHERE sahkoposti = :sposti");
$query->bindParam(':sposti', $_POST["sposti"]);
$query->execute();

$login = false;
$email_found = false;
$_SESSION["login_status"] = false;
$_SESSION["kayttajanimi"] = "";
$_SESSION["sahkoposti"] = "";
$_SESSION["bio"] = "";
$_SESSION["email_found"] = false;

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    if (strtolower($_POST["sposti"]) === strtolower($row["sahkoposti"]) && password_verify($_POST["ssna"], $row["salasana"])) {
        $_SESSION["kayttajanimi"] = $row["kayttajanimi"];
        $_SESSION["kayttaja_id"] = $row["kayttaja_id"];
        $_SESSION["username"] = $row["kayttajanimi"];
        $_SESSION["sahkoposti"] = $row["sahkoposti"];
        $_SESSION["bio"] = $row["bio"];
        $login = true;
        $_SESSION["login_status"] = true;
        header("Location: ../html/etusivu.php");
        exit();
    } else {
        echo "Wrong username or password";
    }

    if ($_POST["sposti"] === strtolower($row["sahkoposti"])) {
        $email_found = true;
        $_SESSION["email_found"] = true;
    }
}

if ($email_found !== true) {
    header("Location: ../html/rekisterointisivu.php");
    echo "Sähköpostia ei ole vielä rekisteröity.";
    session_destroy();
}
?>
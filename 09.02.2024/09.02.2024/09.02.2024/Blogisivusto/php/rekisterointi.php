<?php
session_start();

//to do
//korjaa, että jos rekisteröityy niin pysyisi sisäänkirjautuneena
//vaihda vaikka etusivulle kun rekisteröity ja lisää rekisteröitymisviesti

// katsoo onko salasanat samat
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["ssna"] !== $_POST["ssna_retype"]) {
        echo "Passwords do not match. Please try again.";

        exit();
    }
}

try {
    $connection = new PDO("mysql:host=localhost;dbname=blogi", "root", "");
} catch (PDOException $e) {
    die("ERROR" . $e->getMessage());
}

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->exec("SET NAMES utf8");

$query = $connection->prepare("SELECT * FROM kayttajat");
$query->execute();

$how_many = $connection->lastInsertId();
$registered = false;

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

    if (strtolower($_POST["sposti"]) === strtolower($row["sahkoposti"])) {
        echo "Sähköpostiosoite on jo rekisteröity.";
        $registered = true;

    } 
}
    if ($registered === false) {
        echo "Kelpaa\n";
        // lisätään databaseen & ja salasana salataan
        $hashedPassword = password_hash($_POST["ssna"], PASSWORD_DEFAULT);
        $stmt_01 = $connection->prepare("INSERT INTO kayttajat (kayttajanimi, salasana, sahkoposti) VALUES (:kayttajanimi, :salasana, :sahkoposti)");
        $stmt_01->execute([':kayttajanimi' => $_POST['knimi'], ':salasana' => $hashedPassword, ':sahkoposti' => $_POST['sposti']]);
        echo "Lisätty databaseen.\n";
    }



<?php
session_start();

try {
    $connection = new PDO("mysql:host=localhost;dbname=blogi", "root", "");
} catch (PDOException $e) {
    die("ERROR" . $e->getMessage());
}

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->exec("SET NAMES utf8");

$query = $connection->prepare("SELECT * FROM kayttajat");
$query->execute();

//Tallennetaan lähetetty käyttäjänimi ja bio muuttujiin.
$_SESSION["updated_bio"] = $_POST["bio"];
$_SESSION["updated_kayttajanimi"] = $_POST["knimi"];

//Tarkistetaan onko käyttäjän (sähköpostin) salasana oikein.
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    if (strtolower($_POST["sposti"]) === strtolower($row["sahkoposti"]) && password_verify($_POST["nyk_ssna"], $row["salasana"])) {
        $stmt_01 = $connection->prepare("UPDATE kayttajat SET kayttajanimi = :kayttajanimi, bio = :bio WHERE sahkoposti = :email");
        $stmt_01->execute([':kayttajanimi' => $_SESSION["updated_kayttajanimi"], ':bio' => $_SESSION["updated_bio"], ':email' => $_POST['sposti']]);

        //Päivitetään bio ja käyttäjänimi.
        $_SESSION['kayttajanimi'] = $_SESSION["updated_kayttajanimi"];
        $_SESSION['bio'] = $_SESSION["updated_bio"];
        
        //Päivitetään salasanaksi uusi salasana jos uudet salasanat ovat samat ja eivät ole tyhjiä.
        //Tähän voisi tehdä myös niin, että salasana ei saa olla liian lyhyt.
        if ($_POST['uusi_ssna'] != "" && $_POST["ssna_retype"] != "" &&
            $_POST['uusi_ssna'] === $_POST["ssna_retype"]) {
                $hashedPassword = password_hash($_POST["uusi_ssna"], PASSWORD_DEFAULT);
                $stmt_01 = $connection->prepare("UPDATE kayttajat SET salasana = :salasana WHERE sahkoposti = :email");
                $stmt_01->execute([':salasana' => $hashedPassword, ':email' => $_POST['sposti']]);
        }
    }
}
    header('Location: ../html/profile.php');
    exit();
?>
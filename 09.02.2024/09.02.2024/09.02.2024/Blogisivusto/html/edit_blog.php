<?php
session_start();

if (isset($_SESSION["kayttajanimi"])) {
    if ($_SESSION['login_status'] == true) {
        $loginStatus = "Kirjautunut käyttäjällä: " . $_SESSION["kayttajanimi"];
    } else {
        $loginStatus = "Ei kirjauduttu";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blogi lomake</title>
    <link rel="stylesheet" href="../css/blogilomake.css">
</head>

<body>

    <div class="moi">
        <div class="navbar">
        <ul>
                <li><a href="../html/etusivu.php">Etusivu</a></li>
                <li><a href="../html/blogilista.php">Blogit</a></li>


        <?php
            if (isset($_SESSION["kayttajanimi"])) {
                if ($_SESSION['login_status'] == true) {
                    echo '<li><a href="../html/profile.php">';
                    echo $loginStatus;
                    echo '</a></li>';
                    echo '<li><a href="../php/kirjaudu_ulos.php">Kirjaudu Ulos</a></li>';
                    echo '<li><a class="active" href="../html/blogilomakesivu.php">Kirjoita blogi</a></li>';
                }
            } else {
                echo '<li><a href="../html/kirjautumissivu.php">Kirjaudu Sisään</a></li>';
                echo '<li><a href="../html/rekisterointisivu.php">Rekisteröidy</a></li>';
                
            }



// Yhdistetään MySql databaseen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Varmistetaan yhteys
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Saadaan blogin id url:stä
$blog_id = $_GET['id'];
$blog_author = "";

// Haetaan tietty blogi
$sql = "SELECT sahkoposti, title, content, DATE_FORMAT(time, '%d-%m-%Y %H:%i') AS formatted_time FROM blogi_table WHERE id = $blog_id";

$result = $conn->query($sql);




// Näytetään blogi
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $blog_author = $row['sahkoposti'];
    
    $sql_02 = "SELECT sahkoposti, kayttajanimi FROM kayttajat WHERE sahkoposti = ?";
    $stmt_02 = $conn->prepare($sql_02);
    $stmt_02->bind_param("s", $blog_author);
    $stmt_02->execute();
    $result_02 = $stmt_02->get_result();

    if ($result_02->num_rows > 0) {
        $row_02 = $result_02->fetch_assoc();
        echo "<h2>Kirjoittanut: " . $row_02['kayttajanimi'] . "</h2>";
    }
    echo "<p>Julkaistu: " . $row['formatted_time'] . "</p>";
    echo "Blogin nimi: <input value =" . $row['title'] . "><br>";
    echo "Blogiteksti: <textarea rows ='9'>" . $row['content'] . "</textarea>";
} else {
    echo "Blogia ei löydetty.";
}




// Jos session sahkoposti = blogin kirjoittaja niiiiiiin -->
if ($_SESSION['sahkoposti'] = $row_02['sahkoposti']) {
    echo '<div id="muokkaus_napit">
        <button class="submitbtn" id="muokkaa_blogia" onclick="window.location=\'blogin_muokkaus.php\'">Tallenna</button>
        <button class="cancelbtn" type="cancel" onclick="history.back();">Hylkää</button>
    </div>';
}
    // Suljetaan database yhteys
    $conn->close();
?>

</body>
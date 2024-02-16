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
    <link rel="stylesheet" href="../css/profile.css">
    <title>Profiili</title>
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
                            echo '<li><a href="../html/blogilomakesivu.php">Kirjoita blogi</a></li>';
                        }
                    } else {
                        echo '<li><a href="../html/kirjautumissivu.php">Kirjaudu Sisään</a></li>';
                        echo '<li><a class="active" href="../html/rekisterointisivu.php">Rekisteröidy</a></li>';
                    }

?>
            </ul>
        </div>

          <div class="container">

          <?php
echo '<div id="ylarivi">';
echo '<h1>' . $_SESSION["kayttajanimi"] . '</h1>';
echo '<button id="muokkaa_profiilia" onclick="window.location=\'profile_settings.php\';">Muokkaa profiilia</button>';
echo '</div>';
echo '<h2>Tietoja minusta</h2>';
echo '<h3>' . $_SESSION["bio"] . '</h3>';
echo '<h2>Blogit</h2>';
echo '<h3>';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogi";
$kayttaja = $_SESSION["sahkoposti"];


$conn = new mysqli($servername, $username, $password, $dbname);

// Varmistetaan yhteys
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haetaan kaikki blogit
$sql = "SELECT id, title FROM blogi_table WHERE sahkoposti = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $kayttaja);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<li><a href='view_blog.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
    }

    $stmt->close();
} else {
    echo "Error in preparing the statement: " . $conn->error;
}

$conn->close();

?>
</h3>

             <br>
          </div>

          <script src="../profile.js"></script>
</body>

</html>
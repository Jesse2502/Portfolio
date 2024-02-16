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
    <link rel="stylesheet" href="../css/etusivu.css">
    <title>Etusivu</title>
</head>

<body>
    <div class="main">
        <video autoplay muted loop plays-inline id="myVideo">
            <source src="../media/etusivuvideo.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="navbar">
            <ul>
                <li><a class="active" href="../html/etusivu.php">Etusivu</a></li>
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
                        echo '<li><a href="../html/rekisterointisivu.php">Rekisteröidy</a></li>';
                    }

                ?>
            </ul>
        </div>
        <div class="heading">
            <div class="head">TERVETULOA ETUSIVULLE</div>
        </div>
    </div>
</body>

</html>
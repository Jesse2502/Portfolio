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
    <link rel="stylesheet" href="../css/rekisterointi.css">
    <title>Rekisteröidy</title>
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
        <form action="../php/rekisterointi.php" method="post">


          <div class="container">
            <label for="knimi"><b>Käyttäjänimi</b></label>
            <input type="text" placeholder="Käyttäjänimi" name="knimi" required>

            <label for="sposti"><b>Sähköposti</b></label>
            <input type="email" placeholder="Sähköposti" name="sposti" required>

            <label for="ssana"><b>Salasana</b></label>
            <input type="password" placeholder="Anna salasana" name="ssna" required>

            <label for="ssana_retype"><b>Salasana uudelleen</b></label>
            <input type="password" placeholder="Anna salasana uudelleen" name="ssna_retype" required>
            <label>
              <input type="checkbox" checked="checked" name="muista">Hyväksyn ehdot
            </label>
            <button type="submit">Rekisteröidy</button>
             <br>
          </div>

        </form>

</body>

</html>
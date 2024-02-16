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
                        echo '<li><a class="active" href="../html/profile.php">';
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

        <form action="../php/profiilin_paivitys.php" method="post">

          <div class="container">
          <h1>Muokkaa profiiliasi</h1>
            <label for="knimi"><b>Käyttäjänimi</b></label>
            <?php
                echo '<input type="text" value="' . $_SESSION["kayttajanimi"] . '" name="knimi" required>';
                echo '<label for="sposti"><b>Sähköposti</b></label>';
                echo '<input id="profile_email" type="email" value="' . $_SESSION["sahkoposti"] . '" name="sposti" readonly required>';

                echo '<label for="bio"><b>Tietoja minusta</b></label>
                <br>
                <textarea id="bio" type="text" name="bio" required>' . $_SESSION["bio"] . '</textarea>'
            ?>
            <br>
            <label for="nyk_ssana"><b>Nykyinen salasana</b></label>
            <input type="password" placeholder="Nykyinen salasana" name="nyk_ssna" required>

            <label for="uusi_ssana"><b>Uusi salasana</b></label>
            <input type="password" placeholder="Uusi salasana" name="uusi_ssna">

            <label for="uusi_ssana_retype"><b>Uusi salasana uudelleen</b></label>
            <input type="password" placeholder="Anna uusi salasana uudelleen" name="ssna_retype">
            <div id="muokkaus_napit">
                <button class="submitbtn" type="submit">Tallenna</button>
                <button class="cancelbtn" type="cancel" onclick="window.location='profile.php';">Hylkää</button>
            </div>
             <br>
          </div>

        </form>

</body>

</html>
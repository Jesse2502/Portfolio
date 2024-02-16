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
  <link rel="stylesheet" href="../css/kirjau.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kirjaudu sisään</title>
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
                      echo '<li><a class="active" href="../html/kirjautumissivu.php">Kirjaudu Sisään</a></li>';
                      echo '<li><a href="../html/rekisterointisivu.php">Rekisteröidy</a></li>';
                  }

                ?>
            </ul>
    </div>
    <form action="../php/todennus.php" method="post">


      <div class="container">
        <label for="sposti"><b>Sähköposti</b></label>
        <!-- Pitää tarkistaa, että sähköpostilla on oikea muoto -->
        <input type="text" placeholder="Sähköposti" name="sposti" required>

        <label for="ssana"><b>Salasana</b></label>
        <input type="password" placeholder="Anna salasana" name="ssna" required>

        <button type="submit">Kirjaudu</button>
        <label>
          <input type="checkbox" checked="checked" name="muista"> Muista minut
        </label> <br>
      </div>

      <div class="container" style="background-color:#f1f1f1">

        <span class="ssna">Unohditko <a href="#">Salasanasi?</a></span>
      </div>
    </form>
</body>

</html>
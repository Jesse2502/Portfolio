<?php
session_start();

if (isset($_SESSION["kayttajanimi"])) {
    if ($_SESSION['login_status'] == true) {
        $loginStatus = "Kirjautunut käyttäjällä: " . $_SESSION["kayttajanimi"];
    } else {
        $loginStatus = "Ei kirjauduttu";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['message']) && isset($_POST['time'])) {
        $message = $_POST['message'];
        $time = $_POST['time'];
        file_put_contents("log.txt", $time);
        $current_time = new DateTime();
        $current_time = new DateTime(date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($current_time->format('Y-m-d H:i:s')))));
        $user_time = new DateTime($time);
        //$result = $date->format('Y-m-d H:i:s');
        file_put_contents("log.txt", "current_time: ".$current_time->format('Y-m-d H:i:s').",\n user_time: ".$user_time->format('Y-m-d H:i:s'));
        if ($current_time >= $user_time) {
            echo "Kiitos viestistäsi, blogisi on julkaistu!";
        } else {
            echo "Blogisi julkaisuaika ei ole vielä tullut.";
        }
    } else {
        echo "Virhe: Lomakkeen viestiä tai aikaa ei saatu.";
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

                ?>
            </ul>
        </div>


        <form method="post" action="blogiadd.php">
    <div class="input-group">
        <textarea name="message" rows="8" required><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea>
        <label for="message">Sinun blogisi</label>
    </div>
    <div class="input-group">
        <input type="datetime-local" name="time" required>
        
    </div>
        <button type="submit">LÄHETÄ</button>
    
       
    </form>

</div>

</body>
</html>
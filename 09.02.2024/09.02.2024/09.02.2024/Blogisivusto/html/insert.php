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

                ?>
            </ul>
        </div>
        
        <?php
 
        // servername => localhost
        // username => root
        // password => empty
        // database name => blogi
        $conn = mysqli_connect("localhost", "root", "", "blogi");
         
        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. "
                . mysqli_connect_error());
        }
         
        // Taking all 5 values from the form data(input)
        $content =  $_REQUEST['content'];
        $title = $_REQUEST['title'];
        $author = $_SESSION['sahkoposti'];

        // Performing insert query execution
        // here our table name is blogi_table
        $sql = "INSERT INTO blogi_table(sahkoposti,title,content) VALUES ('$author', '$title', '$content');";
         
        if(mysqli_query($conn, $sql)){
            echo "<h3>Blogi julkaistu!</h3>"; 
            echo "<h1>$title";
            echo "<span>$content</span></h1>";
        } else{
            echo "ERROR: Hush! Sorry $sql. "
                . mysqli_error($conn);
        }
         
        // Close connection
        mysqli_close($conn);
        ?>
        <li><a href="../html/etusivu.php">Palaa etusivulle</a></li>
    </center>
</body>
 
</html>

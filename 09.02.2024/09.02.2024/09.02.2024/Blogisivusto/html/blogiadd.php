<?php
try {
    $yhteys = new PDO ("mysql:host=localhost;dbname=blogi", "root", "");
}   catch (PDOException $e) {
    die("VIRHE: ". $e->getMessage());
}
$time=$_POST["time"];
var_dump($_POST);
$sql="INSERT INTO `blogi_table`( `sahkoposti`, `title`, `content`, `time`) VALUES (:sahkoposti, :title ',':content',':CURRENT_TIME)";
$kysely = $yhteys->prepare($sql);
$kysely->execute([":sahkoposti" =>$sahkoposti, ":title" => $title, ":content" => $content, ":CURRENT_TIME" => $time ]);

?>
<?php
if ( isset($_GET["IndexNo"]) ) {
    $IndexNo = $_GET["IndexNo"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "examinations";

    //Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM students WHERE IndexNo=$IndexNo";
    $connection->query($sql);
}

header("location: /mpesa/index.php");
exit;
?>
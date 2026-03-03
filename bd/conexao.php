<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "yggdrasil_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$coon) {
    die("Erro na conexão: " . mysqli_connect_error());

}

?>
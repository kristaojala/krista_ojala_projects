<?php
/* En tietenkään laittaisi varsinaisia ​​tietokantatietoja GitHubiin, mutta koska tämä on vain perus paikallinen tietokanta, jätin sen tähän esitelläkseni, kuinka yhteys muodostetaan. */
/* Obviously I would not put actual database information in GitHub, but as this is just a generic local database, I left it here to showcase how the connection is made. */
$host = "mysql_db";
$username = "root";
$password = "root";
$dbname = "housing_company_db";

$mysqli = new mysqli($host, $username, $password, $dbname);

if($mysqli->connect_error){
    die("Connection failed: " . $mysqli->connect_error);
}
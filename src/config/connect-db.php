<?php

$host = 'localhost';
$dbname = 'ContractorConnector';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname";

// Class Hosted Database
/*
 $username = 'jad7qt_b';
 $password = 'UpsornWinter2023';
 $host = 'mysql01.cs.virginia.edu';
 $dbname = 'jad7qt_b';
 $dsn = "mysql:host=$host;dbname=$dbname";
*/

// GCP Database
/* 
if(isset($_SESSION['Type'])){
    if($_SESSION['Type'] == 'Administrator'){
        $username = 'root';
        $password = 'UpsornWinter2023';
    }elseif($_SESSION['Type'] == 'Technician'){
        $username = 'technician';
        $password = 'UpsornWinter2023_b';
    }
}
if (!isset($username)){
    $username = 'customer';
    $password = 'UpsornWinter2023_c';
}
$host = 'contractorconnecter:us-east4:contractordb';
$dbname = 'cc';
$dsn = "mysql:unix_socket=/cloudsql/$host;dbname=$dbname";
*/


// FOR LOCAL XAMPP w GCP Database
// if(isset($_SESSION['Type'])){
//     if($_SESSION['Type'] == 'Administrator'){
//         $username = 'root';
//         $password = 'UpsornWinter2023';
//     }elseif($_SESSION['Type'] == 'Technician'){
//         $username = 'technician';
//         $password = 'UpsornWinter2023_b';
//     }
// }
// if (!isset($username)){
//     $username = 'customer';
//     $password = 'UpsornWinter2023_c';
// }
// $host = 'contractorconnecter:us-east4:contractordb';
// $dbname = 'cc';
// $dsn = "mysql:host=34.85.250.218;dbname=$dbname";   // connect PHP (XAMPP) to DB (GCP)

// To connect from a local PHP to GCP SQL instance, need to add authormized network
// to allow (my)machine to connect to the SQL instance. 
// 1. Get IP of the computer that tries to connect to the SQL instance
//    (use http://ipv4.whatismyv6.com/ to find the IP address)
// 2. On the SQL connections page, add authorized networks, enter the IP address

try
{
    $db = new PDO($dsn, $username, $password);
}
catch(PDOException $e)
{
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch(Exception $e)
{
    $error_message = $e->getMessage();
    echo "<p>Error message: $error_message </p>";
}
?>
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "doctor";

$db = new PDO("mysql:host=$host",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// other init
date_default_timezone_set("Africa/Lagos");
session_start();

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "doctor");

if (!$exists) {
    //create the database
    $db->exec("CREATE TABLE doctor (
    doctor_id   INTEGER       PRIMARY KEY AUTOINCREMENT NOT NULL,
    doctor_name VARCHAR (100) NOT NULL
    );");

    $db->exec("CREATE TABLE appointment (
    appointment_id              INTEGER       PRIMARY KEY AUTOINCREMENT NOT NULL,
    appointment_start           DATETIME      NOT NULL,
    appointment_end             DATETIME      NOT NULL,
    appointment_patient_name    VARCHAR (100),
    appointment_status          VARCHAR (100) DEFAULT 'free' NOT NULL,
    appointment_patient_session VARCHAR (100),
    doctor_id                   INTEGER       NOT NULL
    );");

    $items = array(
        array('name' => 'Doctor 1'),
        array('name' => 'Doctor 2'),
        array('name' => 'Doctor 3'),
        array('name' => 'Doctor 4'),
        array('name' => 'Doctor 5'),
    );
    $insert = "INSERT INTO doctor (doctor_name) VALUES (:name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $name = $m['name'];
      $stmt->execute();
    }

}

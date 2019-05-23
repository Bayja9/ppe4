<?php

  $host="localhost";
  $dbname="ajax_test";
  $user="root";
  $pass="";
  try {
    $conn=new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$pass);
    $conn-> exec('SET NAMES utf8');
  }
  catch (Exception $e) {
    die('erreur '.$e->getmessage());
  }
?>

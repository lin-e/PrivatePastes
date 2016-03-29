<?php
  include('config.php');
  $db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name) or die("ERROR: Failed to connect to database");
  if ($_GET['mode'] == "global") {
    $pasteCheck = mysqli_query($db, "SELECT * FROM $db_tablename");
    $activePastes = strval(mysqli_num_rows($pasteCheck));
    echo $activePastes;
  } elseif ($_GET['mode'] == "ip") {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ipCheck = mysqli_query($db, "SELECT * FROM $db_tablename WHERE create_ip='$ip'");
    $activePastes = strval(mysqli_num_rows($ipCheck));
    echo $activePastes;
  } elseif ($_GET['mode'] == "del") {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ipCheck = mysqli_query($db, "SELECT * FROM $db_tablename WHERE create_ip='$ip'");
    $activePastes = strval(mysqli_num_rows($ipCheck));
    mysqli_query($db, "DELETE FROM $db_tablename WHERE create_ip='$ip'");
    echo "Deleted $activePastes paste(s)";
  } else {
    echo "Invalid parameter";
  }
?>
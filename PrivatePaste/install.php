<?php
  include('config.php');
  $db = mysqli_connect($db_hostname, $db_username, $db_password) or die("ERROR: Failed to connect to database");
  if (mysqli_query($db, "CREATE DATABASE $db_name")) {
    mysqli_select_db($db, $db_name);
    $createTable = "CREATE TABLE IF NOT EXISTS `$db_tablename` ( `prime_key` int(11) NOT NULL AUTO_INCREMENT, `content` text NOT NULL, `access_key` text NOT NULL, `create_ip` text NOT NULL, `create_time` text NOT NULL, `melt` int(11) NOT NULL, PRIMARY KEY (`prime_key`) ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
    if ($db->query($createTable) === true) {
      echo "Database and table created successfully. Remove this file for your own security.";
    } else {
      echo "Failed to create new table.";
    }
  } else {
    echo "Failed to create new database, does it already exist?";
  }
?>
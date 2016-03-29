<?php
  include('config.php');
  if ((isset($_POST['content'])) && ($_POST['content'] !== "")) {
    $meltFile = 1;
    if ($_POST['melt'] == "0") {
      $meltFile = 0;
    }
    $db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name) or die("ERROR: Failed to connect to database");  
    $hashFound = false;
    $hash = "";
    $ip = $_SERVER['REMOTE_ADDR'];
    $ipCheck = mysqli_query($db, "SELECT * FROM $db_tablename WHERE create_ip='$ip'");
    if (mysqli_num_rows($ipCheck) >= $activeLimit) {
      echo 'You have too many active pastes!';
    } else {
      while (!$hashFound) {
        $hash = generateRandomString($_POST['content']);
        $useResult = mysqli_query($db, "SELECT * FROM $db_tablename WHERE access_key='$hash'");
        if (mysqli_num_rows($useResult) == 0) {
          $hashFound = true;
        }
      }
      $toUse = fnEncrypt(htmlspecialchars($_POST['content']), $hash);
      $time = strval(time());
      mysqli_query($db, "INSERT INTO $db_tablename (content, access_key, create_ip, create_time, melt) VALUES ('$toUse', '$hash', '$ip', '$time', $meltFile)");
      echo 'Your paste is available at '.$baseDomain.$hash;
    }
  } else {
    echo 'Please enter a message to paste';
  }
  function generateRandomString($pastecontent) {
    $chars = str_split($pastecontent."6eI1lqLswKVKVyz8OyCe1ityeY8VbgJxjD1ybGSl5oODviuJZVIehqFegNQr8ds78geFz2hAPcYiwf0V3wwtQhvR2FUbw3q31CLFVZBA9u0Nfarkx5uUsHZtWKA9oNsYHrblY9oqefrYlY44KJNN5FuuctwsSX1WuxaLLgqPUV2KBL6rtKp2iEUtXMog92w7fncjgFPrAA22nbKb5QLYfrQnsl5I2hYKHd2ANKcbZ2FxFMd1L5o3IbtiN5CbCBoLwzM1v8kRnjB3aTUktUulyAEwQQF5SfSG5zpfSNLRana70BozknL3ly7dgFaQGlWssS6VsJx1kvuJ5KC7f7v5ZE7auY4zMviEPe0ahsyKtJwOi99s1ZXaWiUoxBj0CAfDi4vKP4rPMP5jvMqKkoDuMtiktJEg8e3Jhh2PzRS4S5ALNbztTjsvt9tjSS5jcnnLX2U0SUyr9V2Z3zDRNGd9FJdw1TXOfh3wyRzPtDaKpKCRs2nl0xcLCUKLwzjY7iGQgbM2CJC1jMsD896kMkRwZyeF4GML8vk8gniNOzZye5LQ8gzuxIqxSr3AuiVbjdSoObCctz1OgWZtBxpUgaySnE4F1PTKGMSvdrnce9BXQeRCVnqt4gDpcWW1UU8Pgu7OENn4JUH81tPUAoh8l16Knj0tCLMIgsjh7ZW7jvSnJwzusIfg4zF5a73fFzgogzMMzQBPZ2KpunsuXT7woYWkzPXBXEsGvDH9rFoBZB7EgojaKHIBESizRfjj2PXOZJESVFKqSfoO0eHFitoUEZ86YAPGuEkcyrRFMvzIa1io9YoLOE5NbO8LwVHoPaZpQwU4dHvS7tc2dKW6heDXuWsMSr5jQxwOReL4FvnLpypp1A8x9WcS0eePSfRP7AFfRaLhhQJVt0eKHeQUNs80XCVcnzrpvjDV40TN9Mu3MV7ABfzM2W7fethr6vDZDDHliD2p4vGLaWlDBNVV8y2QWHO3oa7GuMf1WWUfIRMOJZsuYeoBzRXSg5dlXLxs4i50u8fT");
    shuffle($chars);
    $unhashedString = implode($chars);
    return md5($unhashedString);
  }
  function fnEncrypt($sValue, $sSecretKey) {
    return rtrim(
      base64_encode(
        mcrypt_encrypt(
          MCRYPT_RIJNDAEL_256,
          $sSecretKey, $sValue, 
          MCRYPT_MODE_ECB, 
          mcrypt_create_iv(
            mcrypt_get_iv_size(
              MCRYPT_RIJNDAEL_256, 
              MCRYPT_MODE_ECB
            ), 
            MCRYPT_RAND
	      )
        )
      ), "\0"
    );
  }
?>
<?php
  include('config.php');
  date_default_timezone_set('UTC');
  $validHash = false;
  $decryptedContents = "The paste you're looking for either doesn't exist, or already has been opened!";
  $createTime = "N/A";
  $displayedIP = "N/A";
  $hash = strtolower($_GET['hash']);
  $db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name) or die("ERROR: Failed to connect to database");
  $useResult = mysqli_query($db, "SELECT * FROM $db_tablename WHERE access_key='$hash'");
  if (mysqli_num_rows($useResult) > 0) {
    $chosenRow = mysqli_fetch_object($useResult);
    $decryptedContents = fnDecrypt($chosenRow->content, $hash);
    $createIP = $chosenRow->create_ip;
    $ipParts = explode(".", $createIP);
    $displayedIP = array_values($ipParts)[0].".".str_repeat("x", strlen(array_values($ipParts)[1])).".".str_repeat("x", strlen(array_values($ipParts)[2])).".".str_repeat("x", strlen(array_values($ipParts)[3]));
    $createTime = date('l jS \of F Y h:i:s A', intval($chosenRow->create_time));
    $validHash = true;
    if ($chosenRow->melt == 1) {
      mysqli_query($db, "DELETE FROM $db_tablename WHERE access_key='$hash'");
    }
  }
  function fnDecrypt($sValue, $sSecretKey) {
    return rtrim(
      mcrypt_decrypt(
        MCRYPT_RIJNDAEL_256, 
        $sSecretKey, 
        base64_decode($sValue), 
          MCRYPT_MODE_ECB,
          mcrypt_create_iv(
            mcrypt_get_iv_size(
              MCRYPT_RIJNDAEL_256,
              MCRYPT_MODE_ECB
            ), 
          MCRYPT_RAND
        )
      ), "\0"
    );
  }
?>
<html>
  <head>
    <title><?php if ($validHash) { echo "Viewing '$hash'"; } else { echo "File not found"; } ?> [<?php echo $siteName; ?>]</title>
    <link type="text/css" rel="stylesheet" href="assets/css/materialize.css?<?php echo time(); ?>"  media="screen,projection"/>
    <link rel="shortcut icon" href="assets/favicon.ico?<?php echo time(); ?>"/>
    <style>
      body {
        max-width: 100%;
        min-height: 100%;
        background: <?php echo $backgroundColour; ?>;
        color: #ffffff;
        display: flex;
        min-height: 100vh;
        flex-direction: column;
      }
      button {
        min-width: 98% !important;
      }
      main {
        padding: 4.5em 3em 0em 3em;
        flex: 1 0 auto;
      }
    </style>
  </head>
  <body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="assets/js/materialize.js?<?php echo time(); ?>"></script>
    <main>
      <center>
        <div class="row">
          <div class="input-field col s6">
            <textarea id="creator" name="creator" class="materialize-textarea" readonly><?php echo $displayedIP; ?></textarea>
            <label for="creator">Creator IP</label>
          </div>
          <div class="input-field col s6">
            <textarea id="time" name="time" class="materialize-textarea" readonly><?php echo $createTime; ?></textarea>
            <label for="time">Time Created (UTC)</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="content" name="content" class="materialize-textarea" readonly><?php echo $decryptedContents; ?></textarea>
            <label for="content">Note</label>
          </div>
        </div>
        <div class="row">
          <a href="<?php echo $baseDomain; ?>"><button class="waves-effect waves-light btn-large">Create your own paste</button></a>
        </div>
      </center>
    </main>
    <footer class="page-footer">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">
            <h5 class="white-text"><?php echo $siteName; ?></h5>
            <p class="grey-text text-lighten-4"><?php echo $footerMessage; ?></p>
          </div>
          <div class="col l4 offset-l2 s12">
            <h5 class="white-text">Links</h5>
            <ul>
              <li><a class="grey-text text-lighten-3" href="http://materializecss.com/">Materialize</a></li>
              <li><a class="grey-text text-lighten-3" href="http://nanobar.micronube.com/">nanobar.js</a></li>
              <li><a class="grey-text text-lighten-3" href="https://github.com/lin-e">GitHub</a></li>
              <li><a class="grey-text text-lighten-3" href="https://twitter.com/c0mmodity">Twitter</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
          &copy; 2016 lin-e
        </div>
      </div>
    </footer>
  </body>
</html>
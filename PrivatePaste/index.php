<?php
  include('config.php');
?>
<html>
  <head>
    <title>Home [<?php echo $siteName; ?>]</title>
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
    <script type="text/javascript" src="assets/js/nanobar.js?<?php echo time(); ?>"></script>
    <script type="text/javascript">
      var runningCount = 15;
      setInterval(function() {
        runningCount++;
        $.ajax({
          type: "GET",
          url: "api.php",
          data: "mode=ip",
          success: function(data) {
            $("#ipPastes").text(data + " active paste(s) on your IP");
          }
        });
        $.ajax({
          type: "GET",
          url: "api.php",
          data: "mode=global",
          success: function(data) {
            $("#globalPastes").text(data + " active paste(s)");
          }
        });
	  }, 1000);
      function postPaste() {
        if (runningCount >= <?php echo $buttonTimeout; ?>) {	
          var options = {
            bg: '#2ab7a9',
            id: 'mynano'
          };
          var nanobar = new Nanobar(options);
          nanobar.go(0);
          dismissToasts();
          nanobar.go(10);
          var isChecked = $("#melt").is(":checked") ? "1" : "0";
          $.ajax({
            type: "POST",
            url: "post.php",
            data: "content=" + escape($('#content').val()) + "&melt=" + isChecked,
            success: function(data) {
              Materialize.toast(data);
              $('#content').val("");
              $('#melt')[0].checked = true;
              nanobar.go(100);
              runningCount = 0;
            }
          });
        };
      }
      function deletePastes() {
        if (runningCount >= <?php echo $buttonTimeout; ?>) {	
          var options = {
            bg: '#2ab7a9',
            id: 'mynano'
          };
          var nanobar = new Nanobar(options);
          nanobar.go(0);
          dismissToasts();
          nanobar.go(10);
          $.ajax({
            type: "GET",
            url: "api.php",
            data: "mode=del",
            success: function(data) {
              Materialize.toast(data);
              nanobar.go(100);
              runningCount = 0;
            }
          });
        };
      }
      function dismissToasts() {
        $("#toast-container .toast").remove();
      }
    </script>
    <main>
      <center>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="content" name="content" placeholder="Type in your note here" class="materialize-textarea"></textarea>
            <label for="textarea1">Note</label>
          </div>
          <div class="input-field col s12" align="left">
            <input type="checkbox" class="filled-in" id="melt" checked="checked" />
            <label for="melt">Delete after opening (recommended)</label>
          </div>
        </div>
        <div class="row"></div>
        <div class="row">
          <button class="waves-effect waves-light btn-large" onclick="postPaste()">Submit<span id="globalPastes" class="badge"></span></button>
        </div>
        <div class="row">
          <button class="waves-effect waves-light btn-large" onclick="deletePastes()">Delete all my pastes<span id="ipPastes" class="badge"></span></button>
        </div>
        <div class="row">
          <button class="waves-effect waves-light btn-large" onclick="dismissToasts()">Dismiss notifications</button>
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
        <div class="container" align="left">
          &copy; 2016 lin-e
        </div>
      </div>
    </footer>
  </body>
</html>
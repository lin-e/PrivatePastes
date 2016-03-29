<?php
  if (strpos($_SERVER['HTTP_USER_AGENT'], "SkypeUriPreview") !== false) { die("<title>Anti Skype Spying</title>"); } // Anti Skype Spying :)

  $siteName = 'PrivatePastes'; // Name of the entire site
  $footerMessage = 'As soon as the note is read, the row is deleted from the database (if you have set it to do so). There is no guarantee of the security of your notes despite the contents being encrypted with Rijndael 256 as they can be accessed by anyone, should they guess the correct hash.'; // Message shown at the bottom of every page
  $backgroundColour = '#272727'; // Background colour, did you really need this comment?
  $baseDomain = 'http://example.com/priv/'; // Directory this is all hosted in
  $activeLimit = 10; // The max amount of pastes a person can have at once
  $buttonTimeout = 1; // Delay between button presses (seconds)

  $db_username = 'USERNAME'; // MySQL username
  $db_password = 'PASSSWORD'; // MySQL password
  $db_hostname = 'localhost'; // MySQL host
  $db_name = 'priv'; // MySQL database
  $db_tablename = 'main'; // MySQL table
?>
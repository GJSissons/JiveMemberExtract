<html>

<style>
    body {
        color: #5e5e5e;
        font: 13px "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    }
</style>    
    
<body>

<h2>Extract Membership</h2>
<p>To use this service you will need Jive administrator priveleges.</p>
<p>Please enter the URL of your JIVE website along with your username and password below to generate a membership report. Generating the report may take several seconds as the report requires multiple calls to the JIVE REST API.</p>
<form method="post" action="get_membership.php">
  <p>JIVE Website URL:<br>
  <input type="text" name="url"></p>
  <p>Username:<br>
  <input type="text" name="username"></p>
  <p>Password:<br>
  <input type="password" name="password"></p>
  <br><br>
  <input type="submit" value="Get Membership">
</form>
<br><br>

<?php

//if( ini_get('safe_mode') ){
//   echo 'Safe mode is on';
//}else{
//   echo 'Safe mode is off';// 
//}

?>

</body>
</html>

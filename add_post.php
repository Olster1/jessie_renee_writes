<?php
if(isset($_POST["submit"])) {
	$db_file = fopen("posts.txt", "a+") or die("unable to open file");
	//$fileContents = fread($db_file, filesize("posts.txt"));
	$date = getdate();
	$stringToWriteToFile = $date["mday"] . "/" . $date["mon"] . "/" . $date["year"] . "\n";	
	$stringToWriteToFile .= $_POST["title"] . "\n" . $_POST["text"] . "\n//\n";	
	fwrite($db_file, $stringToWriteToFile);
    fclose($db_file);

} else {
	//echo "not post fomr";
}

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Jessie Renee Writes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Homemade+Apple|Marck+Script|Montserrat|Poppins:400|Raleway|Reenie+Beanie" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="text_editor.js"></script>
  </head>
  <body>
  <form id="formToSend" name="formToSend" action="./add_post.php" method="post">
  	<input type="text" name="title" />
  	<br />
  	<input type="hidden" name="text" id="text" value="">
  	<div id="canvas-container"></div>
  	<input type="submit" name="submit">
  </form>	
  
  </body>
  
  <script>

  function processForm(e) {

      var formElm = document.getElementById("formToSend");
  	  var htmlValues = document.getElementById("text");
  	  htmlValues.value = getHtmlBuffer();
      return true;
  }

  var form = document.getElementById('formToSend');
  if (form.attachEvent) {
      form.attachEvent("submit", processForm);
  } else {
      form.addEventListener("submit", processForm);
  }
    
</script>
  </html>
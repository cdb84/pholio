<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<?php
/*Connor Berry 2018
  GNU GPL 3 */
include "connection.php";
/*Build the user's preferences schema*/
$result           = $conn->query("SELECT * FROM pref_schema WHERE user = 'dev'");
$use_descriptions = 0;
$title            = "";
$cr               = "";
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $use_descriptions = $row[use_descriptions];
    $title            = $row[site_title];
    $cr               = $row[copyright];
  } //$row = $result->fetch_assoc()
} //$result->num_rows > 0

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="style.css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>photos</title>
</head>
<body>
  <div class="header">
    <div class="cwd">
      <h3>© <?php
echo $cr;
?></h3>
    </div>
    <div class="back">
      <h3><?php
echo $title;
?></h3>
    </div>
  </div>
  <table class="albums">
    <tr>
      <th><h3>album</h3></th>
	  <?php
if ($use_descriptions) {
  echo "<th><h3>description</h3></th>";
} //$use_descriptions
?>
	</tr>
<?php
/*Beginning looking in our cwd for directories*/
$dir   = '.';
$files = scandir($dir);
foreach ($files as $file) {
  if (!(strpos($file, ".")) && !($file == "." || $file == "..")) {
    /*Upon finding a directory, check it against the DB for info, i.e. to see
     *if the user wants it to be viewable by the public
     */
    $sql    = "SELECT * FROM albums WHERE directory = '" . $file . "' AND publicly_viewable='1'";
    $result = $conn->query($sql);
    /*If we get a return on this directory from the DB*/
    if ($result->num_rows > 0) {
      /*Generate HTML relating to the album*/
      echo "    <tr>\n";
      echo "      <td><a href='" . $file . "'>" . $file . "</a></td>\n";
      /*In particular, be mindful of if we want album descriptions or not, and
       *if the directory exists an album in the DB (else it is a utile folder)
       */
      while ($use_descriptions && $row = $result->fetch_assoc()) {
        echo "      <td><p>" . $row[description] . "</p></td>\n";
      } //$use_descriptions && $row = $result->fetch_assoc()
      echo "    </tr>\n";
    } //$result->num_rows > 0
    /*Opted not to display error info at all here due to security by obscurity*/
  } //!(strpos($file, ".")) && !($file == "." || $file == "..")
} //$files as $file
?>
  </table>  
</body>
</html>
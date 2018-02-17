<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<?php
include "connection.php";
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
<link rel="stylesheet" type="text/css" href="/style.css">
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

$dir   = '.';
$files = scandir($dir);
foreach ($files as $file) {
  if (!(strpos($file, ".")) && !($file == "." || $file == "..")) {
    $sql    = "SELECT * FROM albums WHERE directory = '" . $file . "' AND publicly_viewable='1'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "    <tr>\n";
      echo "      <td><a href='" . $file . "'>" . $file . "</a></td>\n";
      while ($use_descriptions && $row = $result->fetch_assoc()) {
        echo "      <td><p>" . $row[description] . "</p></td>\n";
      } //$use_descriptions && $row = $result->fetch_assoc()
      echo "    </tr>\n";
    } //$result->num_rows > 0
  } //!(strpos($file, ".")) && !($file == "." || $file == "..")
} //$files as $file
?>
  </table>  
</body>
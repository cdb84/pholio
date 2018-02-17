<link rel="stylesheet" type="text/css" href="../style.css"> 
<div class="process">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../connection.php";
$destination_path = $_REQUEST["up_des"];
$target_path      = "../" . $destination_path . "/img/"; //CHECK HERE FOR ABSOL/REL STANDOFF
$caption          = $_REQUEST["caption"];
$target_path      = $target_path . basename($_FILES['uploadedfile']['name']);
$thumbnail_path   = "../" . $destination_path . "/thumbnails/" . basename($_FILES['uploadedfile']['name']);
$trim_name        = basename($_FILES['uploadedfile']['name']);
$resize_coef      = $_REQUEST["resize_coef"];

if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
  $trim_name        = mysqli_real_escape_string($conn, $trim_name);
  $caption          = mysqli_real_escape_string($conn, $caption);
  $destination_path = mysqli_real_escape_string($conn, $destination_path);
  $conn->query('INSERT INTO images (img, caption,album) VALUES ("' . $trim_name . '", "' . $caption . '","' . $destination_path . '")');
  copy($target_path, $thumbnail_path);
  chdir("../" . $destination_path . "/thumbnails/");
  shell_exec("convert " . $trim_name . " -resize " . $resize_coef . "% " . $trim_name);
  echo "The file " . basename($_FILES['uploadedfile']['name']) . " has been uploaded, redirecting you back to panel...";
  header("refresh:2;url=/../admin/index.php");
} //move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)
else {
  echo "There was an error uploading the file.";
}
?>
</div>
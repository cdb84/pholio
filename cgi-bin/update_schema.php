<link rel="stylesheet" type="text/css" href="../style.css"> 
<div class="process">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../connection.php";
$user_schema = "dev";
$sql         = "DELETE FROM `pref_schema` WHERE user='" . $user_schema . "'";
$target_path = "../favicon.ico";
$conn->query($sql);
$use_captions     = (int) isset($_POST["use_captions"]);
$use_descriptions = (int) isset($_POST["use_descriptions"]);
$center_align     = (int) isset($_POST["center-align"]);
$force_height     = (int) isset($_POST["force-height"]);
$title            = $_POST["title"];
$cr               = $_POST["copyright"];
$title            = mysqli_real_escape_string($conn, $title);
$cr               = mysqli_real_escape_string($conn, $cr);
$sql              = 'INSERT INTO pref_schema (user, site_title, copyright, use_captions, use_descriptions, center_align_captions, force_height) VALUES ("' . $user_schema . '","' . $title . '","' . $cr . '", "' . $use_captions . '", "' . $use_descriptions . '", "' . $center_align . '", "' . $force_height . '")';
if ($conn->query($sql)) {
  if (isset($_FILES['icon']['name']) && move_uploaded_file($_FILES['icon']['tmp_name'], $target_path)) {
    echo "Favicon changed. <br>";
  } //isset($_FILES['icon']['name']) && move_uploaded_file($_FILES['icon']['tmp_name'], $target_path)
  echo 'Submission sucessful. Redirecting...';
  header("refresh:2;url=/../admin/index.php");
} //$conn->query($sql)
else {
  echo "A SQL error has occurred. Please contact the webmaster.<br>";
  echo $conn->error . "<br>";
  echo $sql;
}
?>
</div>
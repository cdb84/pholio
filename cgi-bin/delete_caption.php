<link rel="stylesheet" type="text/css" href="../style.css">
<div class="process">
<?php
/*Script to delete photograph off of site*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../connection.php";
$img = $_POST["del_cap"];
/*One upon a time, without this condition, everything broke. The end.
  In essence, always make sure not to pass empty strings to 'rm'*/
if (empty($img) || $img == "none") {
  echo 'Empty image name, aborting...';
  header("refresh:2;url=../admin/index.php");
  exit();
} //empty($img) || $img == "none"
/*Begin fetching DB info for the image*/
$img    = mysqli_real_escape_string($conn, $img);
$sql    = 'SELECT * FROM `images` WHERE `img`="' . $img . '"';
$result = $conn->query($sql);
/*Requisition the directory from DB reported album*/
$dir    = $result->fetch_assoc()[album];
/*Compose the deletion statement*/
$sql    = 'DELETE FROM `images` WHERE `img`="' . $img . '"';
/*Send the deletion to the MySQL server*/
if ($conn->query($sql)) {
  /*Remove the image from the directory tree*/
  unlink("../" . $dir . "/img/" . $img);
  unlink("../" . $dir . "/thumbnails/" . $img);
  echo 'Submission sucessful. Redirecting...';
  header("refresh:2;url=/../admin/index.php");
} //$conn->query($sql)
else {
  echo "A SQL error has occurred. Please contact the webmaster.<br>";
}
$conn->close();
?>
</div>
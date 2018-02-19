<link rel="stylesheet" type="text/css" href="../style.css"> 
<div class="process">
<?php
/*A script to delete albums*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../connection.php";
/*Function takes a path and recursively deletes everything in that directory*/
function rrmdir($dir)
{
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (is_dir($dir . "/" . $object)) {
          rrmdir($dir . "/" . $object);
        } //is_dir($dir . "/" . $object)
        else {
          unlink($dir . "/" . $object);
        }
      } //$object != "." && $object != ".."
    } //$objects as $object
    rmdir($dir);
  } //is_dir($dir)
}
/*The first name of our directory to delete*/
$dir = $_POST["del_des"];
/*Code to prevent everything from exploding*/
if (empty($dir) || $dir == "none") {
  echo 'Empty album name, aborting...';
  header("refresh:2;url=/../admin/index.php");
  exit();
} //empty($dir) || $dir == "none"
$dir = mysqli_real_escape_string($conn, $dir);
/*First, purge it from the DB*/
$sql = 'DELETE FROM `albums` WHERE `directory`="' . $dir . '"';
if ($conn->query($sql)) {
  /*Then, delete the linked images*/
  $sql = 'DELETE FROM `images` WHERE `album`="' . $dir . '"';
  if ($conn->query($sql)) {
    echo "Removed all photos from album<br>Removed album<br>";
  } //$conn->query($sql)
  /*Remove the directory*/
  rrmdir("../" . $dir);
  echo 'Submission sucessful. Redirecting...';
  header("refresh:2;url=/admin/index.php");
} //$conn->query($sql)
else {
  echo "A SQL error has occurred. Please contact the webmaster.<br>";
}
$conn->close();
?>
</div>
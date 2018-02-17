<link rel="stylesheet" type="text/css" href="../style.css">
<div class="process">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../connection.php";
$img = $_POST["del_cap"];
if (empty($img) || $img == "none") {
  echo 'Empty image name, aborting...';
  header("refresh:2;url=/admin/index.php");
  exit();
} //empty($img) || $img == "none"
$img    = mysqli_real_escape_string($conn, $img);
$sql    = 'SELECT * FROM `images` WHERE `img`="' . $img . '"';
$result = $conn->query($sql);
$dir    = $result->fetch_assoc()[album];
$sql    = 'DELETE FROM `images` WHERE `img`="' . $img . '"';

if ($conn->query($sql)) {
  unlink("../" . $dir . "/img/" . $img);
  unlink("../" . $dir . "/thumbnails/" . $img);
  echo 'Submission sucessful. Redirecting...';
  header("refresh:2;url=/admin/index.php");
} //$conn->query($sql)
else {
  echo "A SQL error has occurred. Please contact the webmaster.<br>";
}
$conn->close();
?>
</div>
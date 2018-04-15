<link rel="stylesheet" type="text/css" href="../style.css"> 
<div class="process">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../connection.php";
if (empty($_POST["directory"])) {
  echo 'Empty album name, aborting...';
  header("refresh:2;url=../admin/index.php");
  exit();
} //empty($_POST["directory"])
$dir = $_POST["directory"];
$des = $_POST["description"];

$dir  = mysqli_real_escape_string($conn, $dir);
$dir  = str_replace(' ', '_', $dir);
$des  = mysqli_real_escape_string($conn, $des);
$view = $_POST["publicly_viewable"];
$sql  = 'INSERT INTO albums (directory, description, publicly_viewable) VALUES ("' . $dir . '", "' . $des . '", "' . $view . '")';
mkdir("../" . $dir, 0777);
mkdir("../" . $dir . "/img", 0777);
mkdir("../" . $dir . "/thumbnails", 0777);
copy("../copy-bin/index.php", "../" . $dir . "/index.php");
if ($conn->query($sql)) {
  echo 'Submission sucessful. Redirecting...';
  header("refresh:2;url=/../admin/index.php");
} //$conn->query($sql)
else {
  echo "A SQL error has occurred. Please contact the webmaster.<br>";
}
$conn->close();
?>
</div>

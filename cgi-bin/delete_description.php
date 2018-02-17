<link rel="stylesheet" type="text/css" href="/style.css"> 
<div class="process">
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../connection.php";

function rrmdir($dir) { 
   if (is_dir($dir)) { 
    $objects = scandir($dir); 
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") { 
        if (is_dir($dir."/".$object)){
          rrmdir($dir."/".$object);
        }
        else{
          unlink($dir."/".$object); 
        }
      } 
    }
    rmdir($dir); 
  } 
}
$dir = $_POST["del_des"];
if( empty($dir) || $dir == "none"){
  echo 'Empty album name, aborting...';
  header( "refresh:2;url=/admin/index.php" );
  exit();
}
$dir = mysqli_real_escape_string($conn, $dir);
//test
$sql = 'DELETE FROM `albums` WHERE `directory`="'.$dir.'"';
if ($conn->query($sql)){
  $sql = 'DELETE FROM `images` WHERE `album`="'.$dir.'"';
  if ($conn->query($sql)){
    echo "Removed all photos from album<br>Removed album<br>";
  }
  rrmdir("../".$dir);
  echo 'Submission sucessful. Redirecting...' ;
  header( "refresh:2;url=/admin/index.php" );
}
else {
  echo "A SQL error has occurred. Please contact the webmaster.<br>";
}
$conn->close();
?>
</div>
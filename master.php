<?php
include "../header.php";
include "../connection.php";
/*Connor Berry 2018
  GNU GPL 3 */
$result       = $conn->query("SELECT * FROM pref_schema WHERE user = 'dev'");
$use_captions = 0;
$center_align = 0;
$force_height = 0;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $use_captions = $row[use_captions];
    $center_align = $row[center_align_captions];
    $force_height = $row[force_height];
  } //$row = $result->fetch_assoc()
} //$result->num_rows > 0
?>
  <table>
    <tr>
      <th><h3>photo</h3></th>
      <?php
if ($use_captions) {
  echo "<th><h3>caption</h3></th>";
} //$use_captions
?>
    </tr>
    <tr>
      <th><h6>Click to enlarge</h6></th>
      <?php
if ($use_captions) {
  echo "<th></th>";
} //$use_captions
?>
    </tr>
  <?php
//VERSION 12/19/2017 (restored from earlier backup after fatal program error)
$dirFiles = array();
if ($handle = opendir('img')) {
  while (false !== ($file = readdir($handle))) {
    $crap      = array(
      ".jpg",
      ".jpeg",
      ".JPG",
      ".JPEG",
      ".png",
      ".PNG",
      ".gif",
      ".GIF",
      ".bmp",
      ".BMP",
      "_",
      "-"
    );
    $newstring = str_replace($crap, " ", $file);
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails") {
      $dirFiles[] = $file;
    } //$file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails"
  } //false !== ($file = readdir($handle))
  closedir($handle);
} //$handle = opendir('img')
rsort($dirFiles);
foreach ($dirFiles as $file) {
  $file_path = $folder_path . $file;
  $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
?>  <tr>
<!-- Do the thing here!-->
      <td><a href=
<?php
echo '"img/' . $file_path. '"';
?>><img src=
<?php
echo '"thumbnails/' . $file_path . '" ';
if ($force_height) {
  echo "height=250";
} //$force_height
?> /></a></td>
<?php
$sql    = "SELECT * FROM images WHERE img = '" . $file_path . "'";
$result = $conn->query($sql);
//this just prints based on the query results
if ($result->num_rows > 0) {
  while ($use_captions && $row = $result->fetch_assoc()) {
?>
        
      <td><p class="pcell"<?php
  if ($center_align) {
    echo 'align="center"';
  } //$center_align
?>> <?php
  echo $row[caption];
?> </p></td><?php
  } //$use_captions && $row = $result->fetch_assoc()
} //$result->num_rows > 0
  else {
?>
      
      <td> </td><?php
  }
?>
    
    </tr>
  <?php
} //$dirFiles as $file
?>
  </table>

</body>
</html>
<?php
include "../connection.php";
/*Initialization of preference schema*/
$user_schema      = "dev";
$use_captions     = 0;
$use_descriptions = 0;
$center_align     = 0;
$force_height     = 0;
$title            = "";
$cr               = "";
$result           = $conn->query("SELECT * FROM pref_schema WHERE user = '" . $user_schema . "'");
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $title            = $row[site_title];
    $cr               = $row[copyright];
    $use_captions     = $row[use_captions];
    $use_descriptions = $row[use_descriptions];
    $center_align     = $row[center_align_captions];
    $force_height     = $row[force_height];
  } //$row = $result->fetch_assoc()
} //$result->num_rows > 0
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="icon" href="/favicon.ico" type="image/x-icon" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Admin Panel</title>
</head>
<body>
  <div class="header">
    <div class="cwd">
      <h3>Admin Panel</h3>
    </div>
    <div class="back">
      <h3><a href=".."/>back</a></h3>
    </div>
  </div>
  <br>
  <br>
  <div class="admin">
    <h1>Display Preferences</h1>
    <table class = "formclass">
      <form enctype="multipart/form-data" action="/cgi-bin/update_schema.php" method="POST">
        <tr>
          <td>Use Image Captions?</td>
          <td><input type="checkbox" name="use_captions" value="1"<?php
if ($use_captions) {
  echo "checked";
} //$use_captions
?>></td>
        </tr>
        <tr>
          <td>Use Album Descriptions?</td>
          <td><input type="checkbox" name="use_descriptions" value="1"<?php
if ($use_descriptions) {
  echo "checked";
} //$use_descriptions
?>></td>
        </tr>
        <tr>
          <td>Center Align Image Captions?</td>
          <td><input type="checkbox" name="center-align" value="1"<?php
if ($center_align) {
  echo "checked";
} //$center_align
?>></td>
        </tr>
		<tr>
		  <td>Force Uniform Thumbnail Size?</td>
		  <!-- remember to include php code here for checkbox -->
		  <td><input type="checkbox" name="force-height" value="1"<?php
if ($force_height) {
  echo "checked";
} //$force_height
?>></td>
		</td>
        <tr>
          <td>Website/Portfolio Title Information</td>
          <td><input type="text" name="title" value=<?php
echo '"' . $title . '"';
?>></td>
        </tr>
        <tr>
          <td>Copyright Infomation</td>
          <td><input type="text" name="copyright" value=<?php
echo '"' . $cr . '"';
?>></td>
        </tr>
        <tr>
          <td>Website Icon</td>
        </tr>
        <tr>
          <td><img height="35" src="../favicon.ico"/></td>
          <td><input type="file" size="35" name="icon"/></td>          
        </tr>
        <tr>
          <td><input type="submit" name="update_schema" value="Update Preferences"></td>
        </tr>
      </form>
    </table>
    <h1>Create an album</h1>
    <h6>Must not match name of another album.</h6>
    <table class="formclass">
      <form action="/cgi-bin/submit_description.php" method="POST">
          <tr>
            <td>Name of album</td>
            <td><input type="text" name="directory" size="40"></td>
          </tr>
          <tr>
            <td>Description of album</td>
            <td><input type="text" name="description" size="60"></td>
          </tr>
		  <tr>
			<td>Publicly viewable from album list?</td>
			<td><input type="checkbox" name="publicly_viewable" value="1" checked></td>
		  </tr>
          <tr>
            <td><input type="submit" name="submit_description" value="Submit"></td>
          </tr>
      </form>
    </table>
    <h1>Upload a Photo</h1>
    <h6>This operation will overwrite any photo in this album with the same name. Smaller thumbnail sizes are beneficial for larger images.</h6>
    <table class="formclass">
      <form enctype="multipart/form-data" action="/cgi-bin/upload.php" 
      method="post">
        <tr>
          <td>Select File:</td>
          <td><input type="file" size="35" name="uploadedfile" /></td>
        </tr>
        <tr>
          <td>Indicate Album:</td>
          <td>
            <select name="up_des"><?php
$sql = "SELECT * FROM `albums`";
if ($res = $conn->query($sql)) {
  while ($row = mysqli_fetch_row($res)) {
    echo "\n              <option value=" . $row[0] . ">" . $row[0] . "</option>";
  } //$row = mysqli_fetch_row($res)
} //$res = $conn->query($sql)
else {
  echo "Error:" . $sql . "<br>" . $conn->error;
}
?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            Thumbnail Size:
          </td>
          <td>
            <select name="resize_coef">
              <option value="3.125">3.125%</option>
              <option value="6.25">6.25%</option>
              <option selected="selected" value="12.5">12.5%</option>
              <option value="25">25%</option>
              <option value="50">50%</option>
              <option value="75">75%</option>
              <option value="100">100%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Caption (can be blank):</td>
          <td><input type="text" size="35" name="caption" /></td>
        </tr>
        <tr>
          <td><input type="submit" name="Upload" value="Upload" /></td>
        </tr>
      </form>
    </table>
    <h1>Delete an album</h1>
    <table class="formclass">
      <form action="/cgi-bin/delete_description.php" method="POST">
        <tr>
          <select name="del_des">
            <option value="none"> </option><?php
$sql = "SELECT * FROM `albums`";
if ($res = $conn->query($sql)) {
  while ($row = mysqli_fetch_row($res)) {
    echo "\n            <option value=" . $row[0] . ">" . $row[0] . "</option>";
  } //$row = mysqli_fetch_row($res)
} //$res = $conn->query($sql)
else {
  echo "Error:" . $sql . "<br>" . $conn->error;
}
?>        
          </select>
        </tr>
      <br>
      <br>
        <tr>
          <td><input type="submit" name="description_delete" value="Delete"></td>
        </tr>
      </form>
    </table>
    <h1>Delete a photo</h1>
    <table class="formclass">
      <form action="/cgi-bin/delete_caption.php" method="POST">
        <tr>
          <select name="del_cap">
			<option value="none"> </option><?php
$sql = "SELECT * FROM `images`";
if ($res = $conn->query($sql)) {
  while ($row = mysqli_fetch_row($res)) {
    echo "\n            <option value=" . $row[0] . ">" . $row[0] . ", " . $row[1] . ", " . $row[2] . "</option>";
  } //$row = mysqli_fetch_row($res)
} //$res = $conn->query($sql)
else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
            
          </select>
        </tr>
      <br>
      <br>
        <tr>
          <td><input type="submit" name="caption_delete" value="Delete Photo"></td>
        </tr>
      </form>
    </table>
    <h1>Site Information</h1>
    <p>This site was created in December 2017 by Connor Berry to handle photography portfolios. It is not currently mobile-optimized, but it is mobile-resilient, meaning that the site can still function fully despite being used on a mobile browser, alongside viewing and input difficulties.</p>
  </div>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

function getCurrentDirectory()
{
  $path     = dirname($_SERVER['PHP_SELF']);
  $position = strrpos($path, '/') + 1;
  return substr($path, $position);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="/style.css"> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php
echo getCurrentDirectory();
?></title>
</head>
<body>
  <div class="header">
    <div class="cwd">
      <h3><?php
echo getCurrentDirectory();
?></h3>
    </div>
    <div class="back">
      <h3><a href=".."/>back</a></h3>
    </div>
  </div>
</body>
<?php
function getCurrentDirectory()
{
  $path     = dirname($_SERVER['PHP_SELF']);
  $position = strrpos($path, '/') + 1;
  return substr($path, $position);
}
echo "User=" . $_ENV[USER] . "<br>";
echo get_current_user() . "<br>";
echo posix_getuid() . "<br>";
echo getCurrentDirectory() . "<br>";
echo getcwd() . "<br>";
echo ini_get('upload-max-filesize'), '<br>', ini_get('post-max-size'), '<br>';
echo "***";
phpinfo();
?>
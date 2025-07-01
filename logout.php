<?php
session_start();
session_destroy();
header("Location: hello.php");
exit();
?>

<?php

if (isset($_COOKIE['pass']) && isset($_COOKIE['user'])) 
{
    setcookie("user", "", mktime(0, 0, 0, 1, 1, 1970));
    setcookie("pass", "", mktime(0, 0, 0, 1, 1, 1970));
    header("Location: ./index.php");
    exit;
}

header("Location: ./index.php");
exit;

?>
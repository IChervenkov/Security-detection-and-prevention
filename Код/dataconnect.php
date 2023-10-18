<?php

$link1 = @mysqli_connect("localhost", "login", "login123", "project");
@mysqli_set_charset($link1, "ascii");

if (!$link1) {
    echo 'Database maintenance';
    exit;
}

$link2 = @mysqli_connect("localhost", "register", "register123", "project");
@mysqli_set_charset($link2, "ascii");
$user=@mysqli_real_escape_string($link2, $user);
$pass=@mysqli_real_escape_string($link2, $pass);

if (!$link2) 
{
    echo 'Database maintenance';
    exit;
}
?>
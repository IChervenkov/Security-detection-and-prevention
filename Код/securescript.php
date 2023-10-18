<?php
    session_start();
    session_regenerate_id(true);

    function insertReport($user, $description)
    {
        include './dataconnect.php';
        $sql = 'INSERT INTO report(users, date, descriptionOfProblem) VALUES
			("'.$user.'",
             NOW(),
             "'.$description.'"
			)';

        @mysqli_query($link1, $sql);
    }

    function makeIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 
        else 
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }

    function makeURL()
    { 
       if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
        {
            $url = "https://";
        } 
        else 
        {
            $url = "http://";
        }

        $url.= $_SERVER['HTTP_HOST'];
    
        $url.= $_SERVER['REQUEST_URI'];

        return $url;
    }

    function insertDataForLogin($user,$ip_address,$os,$url)
    {
        include './dataconnect.php';
        $sql = 'INSERT INTO infoUser(users, ip, os, viewpage, date) VALUES
			("'.$user.'",
			 "'.$ip_address.'",
             "'.$os.'",
             "'.$url.'",
             NOW()
			)';

        @mysqli_query($link2, $sql);
    }

    insertDataForLogin($_SESSION['user'],makeIP(), php_uname("s"), makeURL());

    if ($_SERVER['HTTP_USER_AGENT']!==$_SESSION['user_agent']) 
    {
        insertReport($_SESSION['user'],"Засечен е Session fixation, в следствие на това правата на потребителя са отнети чак се деиствие.");
        session_destroy();
        exit;
    }

    echo "Hello"
?>
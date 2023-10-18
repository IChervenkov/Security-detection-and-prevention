<?php
    require("botcheck.php");
    DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
    DEFINE("CIPHER", "aes-256-ctr");
    DEFINE("AESKEY", 'RE43kl34*&rEweAdYtNnPP[]qwSA7&43');
    
    session_start();
    session_regenerate_id(true);

    if (isset($_POST['register'])) 
    {
        add_ip();
        header("Location: ./register.php");
        exit;
    }
    
    // Проверка дали имаме налични "бисквитки", ако да те се декриптират

    if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) 
    {
        $user = openssl_decrypt($_COOKIE['user'], CIPHER, AESKEY, 0, base64_decode($_COOKIE['civ']));
        $pass = openssl_decrypt($_COOKIE['pass'], CIPHER, AESKEY, 0, base64_decode($_COOKIE['civ'])).PEPPER;
    }

    // ако няма налични "бисквитки" се проверява дали са въведени данни за потребителско име и парола

    else if (isset($_POST['user']) && isset($_POST['pass'])) 
    {
        $user = $_POST['user'];
        $pass = $_POST['pass'].PEPPER;
    } 
    else 
    {
        header("Location: ./index.php");
        exit;
    }
    
    
    include './dataconnect.php';

    $sql = 'SELECT id, pass FROM users WHERE user = ?';
    
    // добър начин за избягване на sql injective (задава се перманентно желаната заявка и не може да се добавят специфични изрази към нея например ...WHERE 1=1, 
	// дори и да се добавят такира изрази те ще се възприемат като текст)

    $statement = mysqli_stmt_init($link1);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement, "s", $user);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $row['id'], $row['pass']);
    mysqli_stmt_fetch($statement);

    // проверка дали има наличен профил за въведените данни, ако няма "бисквитките" се нулират

    if (!isset($row['id'])) 
    {
        add_ip();
        setcookie("user", "", mktime(0, 0, 0, 1, 1, 1970));
        setcookie("pass", "", mktime(0, 0, 0, 1, 1, 1970));
        header("Location: ./index.php");
        exit;
    }

    // проверка дали хешираната парола която се съхранява в базата съвпада с въведената, ако не "бисквитките" се нулират

    if (!password_verify($pass, $row['pass'])) 
    {
        add_ip();
        setcookie("user", "", mktime(0, 0, 0, 1, 1, 1970));
        setcookie("pass", "", mktime(0, 0, 0, 1, 1, 1970));
        header("Location: ./index.php");
        exit;
    }

    $_SESSION['uid'] = $row['id'];
    $_SESSION['user'] = $user;

    // запазване на "сесийно id" (id на текущия потребител отворил дадената страница) в променлива

    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    
    if (isset($_POST['remember'])) 
    {    
        $civ = openssl_random_pseudo_bytes(openssl_cipher_iv_length(CIPHER));
        setcookie("user", openssl_encrypt($_POST['user'], CIPHER, AESKEY, 0, $civ), time()+3600);
        setcookie("pass", openssl_encrypt($_POST['pass'], CIPHER, AESKEY, 0, $civ), time()+3600);
        setcookie("civ", base64_encode($civ), time()+3600);
    }
    
    header("Location: ./securescript.php");
    exit;

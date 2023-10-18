<?php
    DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
    session_start();
    session_regenerate_id(true);

$time=74;
$memory=4097;
$thread=1;

if(!isset($_POST['captcha']))
{
    $randomString = strtolower(base64_encode(openssl_random_pseudo_bytes(3))); // генериране на произволен стринг
    $_SESSION['captcha'] = $randomString;
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <meta charset="UTF-8" lang="bg" />
    <link href="./style/style.css?v=<?php echo time();?>" rel="stylesheet" />
    <link href="./icon/lock_icon.png" rel="icon" type="icon/png" />
</head>

<body>
<main>
<h1>Регистрация</h1>

<?php

    if (!isset($_POST['user']) || !isset($_POST['pass1']) || !isset($_POST['pass2'])) 
    {
        goto form;
    }

    if($_SESSION['captcha']!=$_POST['captcha'] || empty($_POST['captcha']))
    {
        $randomString = strtolower(base64_encode(openssl_random_pseudo_bytes(3))); // генериране на произволен стринг
	    $_SESSION['captcha'] = $randomString;

		echo 'Невалиден код';
		goto form;
	}

    if(empty($_POST['user']) || empty($_POST['pass1']) || empty($_POST['pass2']))
    {
        goto form;
    }

    if ($_POST['pass1'] !== $_POST['pass2']) {
        echo 'Паролите не съвпадат<br /><br />';
        goto form;
    }

    $user = $_POST['user'];

    // Хеширане на паролата с алгоритам за хеширане ARGON2ID

    $pass=password_hash($_POST['pass1'].PEPPER, PASSWORD_ARGON2ID, ['memory_cost'=>$memory,'threads'=>$thread,'time_cost'=>$time]);

   include './dataconnect.php';
    $sql = 'INSERT INTO users(user, pass) VALUES
			("'.$user.'",
			 "'.$pass.'"
			)';

    $result = @mysqli_query($link2, $sql);
    if (!$result) 
    {
        echo 'Изберете друго потребителско име';
        goto form;
    }
    echo 'Регистрирахте се успешно!<br /><br />';
    goto backButton;

?>



        <header>
            <h1>Форма за регистрация</h1>
        </header>

        <section>

            <?php form:?><form id="myform" action="./register.php" method="POST">

                <label for="user" class="text">Потребителско име<label title="Това поле е задължително"
                        class="pointed">*</label> </label>

                <input type="text" name="user" placeholder="Потребителско име" />

                <label for="pass1" class="text">Парола <label title="Това поле е задължително"
                        class="pointed">*</label></label>

                <input type="password" name="pass1" placeholder="Парола" />

                <label for="pass2" class="text">Повтори паролата <label title="Това поле е задължително"
                        class="pointed">*</label></label>

                <input style="margin-bottom: 50px;" type="password" name="pass2" placeholder="Повторение на парола" />

                <img style=" margin-bottom: 20px; margin-left: 150px; display: block; border: 1px solid black" src="tool/captcha.php" />
                <input style="margin-bottom: 50px;" type="text" name="captcha" placeholder="Секретен код" />
                <button style="margin-left: 45px;" type="submit" class="button"><span>Регистрираи</span></button>
				<?php backButton:?> <button style="margin-bottom: 50px;" class="button" onclick="location.href ='./index.php'; return false;"><span>Назад</span></button>
            </form>

        </section>

    </main>

</body>

</html>
</body>
</html>
<?php

    // Проверка дали имаме налични "бисквитки"

   if (isset($_COOKIE['user']) && isset($_COOKIE['pass']))
   {
        header("Location: ./login.php");
        exit;
   }
    session_start();
    session_regenerate_id(true);
?>

<!DOCTYPE html>

<html>

<head>
    <title>Вход</title>
    <meta charset="UTF-8" lang="bg" />
    <link href="./style/style.css?v=<?php echo time();?>" rel="stylesheet" />
    <link href="./icon/lock_icon.png" rel="icon" type="icon/png" />
</head>

<body>

    <main>

        <header>
            <h1>Форма за влизане</h1>
        </header>

        <section>

            <form action="login.php" method="POST">

                <label for="user" class="text"> Потребителско име </label>

                <input type="text" name="user" placeholder="Потребителско име" />

                <label for="pass" class="text">Парола</label>

                <input type="password" name="pass" placeholder="Парола" />

                <label class="text" for="remember" >Запомни ме<label> 
                <input type="checkbox" name="remember" value="yes" />

                <button  type="submit" class="button" name="login"><span>Влизане</span></button>
                <button  type="submit" class="button" name="register"><span>Регистрация</span></button>

            </form>

        </section>

    </main>

</body>

</html>
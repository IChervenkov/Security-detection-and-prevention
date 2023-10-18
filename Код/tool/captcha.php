<?php
	session_start();
	header("Content-Type: image/png"); // изобразяване на картина в противен случай се получава поредица от нечетими символи
	header("Cache-Control: no-cache, no-store, must-revalidate"); // браузерът не пази кеш
	header("Pragma: no-cache"); // поддръжка от устарели браузари
	header("Expires: 0"); // ако се пази кеш той се кешира за 0 секунди

	
	$files = glob("../fonts/*.[tT][tT][fF]"); // Получаване на всички файлове (шрифтове) с разширение ttf или TTF запазваики ги като масив от стрингове

	$image = imagecreatetruecolor(200,60); // създаване на изображението (прозореца)
	$background = imagecolorallocate($image, rand(150,255), rand(150,255), rand(150,255)); // създаване на заден фон
	imagefilledrectangle($image, 0, 0, 200, 60, $background); // изрисуване на правоъгълник с създадения заден фон

	for($i=0; $i<strlen($_SESSION['captcha']); $i++)
	{
		$font = $files[array_rand($files)]; // вземане на произволен шрифт
		$fontcolor = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100)); // задаваен на цвят на текста
		imagettftext($image, rand(16,24), rand(-30, 30), 11+22*$i, rand(26, 58), $fontcolor, $font, $_SESSION['captcha'][$i]); // изписва текста в картината със съответния избран шрифт
	}
	
	imagepng($image); //отпечатване на изображението 
	
?>
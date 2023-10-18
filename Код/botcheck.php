<?php

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

function add_ip()
    {
        include './dataconnect.php';
        $ip = mysqli_real_escape_string($link1, $_SERVER['REMOTE_ADDR']);

        // При дублиране на ключа ще се добави 1 към attempts, в противен случаи ще се изпълни заявката

        $sql = "INSERT INTO login_logs_hash(ip) 
				VALUES (INET6_ATON('".$ip."'))
				ON DUPLICATE KEY UPDATE attempts = attempts+1";
                
        $result = mysqli_query($link1, $sql);
    }
    
    include './dataconnect.php';
    $ip = mysqli_real_escape_string($link1, $_SERVER['REMOTE_ADDR']);
    $sql = "SELECT 1 AS blocked
			FROM login_logs_hash
			WHERE ip = INET6_ATON('".$ip."')
						AND
				  attempts > 2";
    $result = @mysqli_query($link1, $sql);
    $row = @mysqli_fetch_assoc($result);
  //   if (isset($row['blocked'])) 
	// {
  //       insertReport($_SESSION['user'], "Засечен е опит за налучкване на парола с това потребителско име евентуално атака от бот, профилът е спрян, необходини са мерки.");
  //       exit;
  //   }

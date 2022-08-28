<?php

    if(!empty($_GET["findable"])) {
        $findable = htmlentities($_GET["findable"]);
    }

    $user = 'root';
    $password = 'root';
    $db = 'base_for_inline';
    $host = 'localhost';
    $link = mysqli_connect($host,$user,$password,$db);

    $found_comments = mysqli_query($link, 
    'SELECT `title`, comments.`body`
     FROM `posts`
     INNER JOIN `comments` ON `postId`= posts.`id`
     WHERE comments.`body` LIKE "%'.$findable.'%"');

    $count = 0;
    $answer = "<dl>";
    for($tmp = [];$row = mysqli_fetch_assoc($found_comments); $tmp[]= $row) {
        $answer .= "<dt><b>Title: '".$row["title"]."'</b></dt><dd>Comment: '".$row["body"]."'</dd><br>";
        $count++;
    }
    $answer .= "</dl>";
    if($count > 0) {
        echo "По запросу `".$findable."` найдено ".$count." ".numberProblem($count).":<br>";
        echo $answer;
    }
    else if(!empty($error = mysqli_error($link))){ 
        echo "Ошибка сервера: ".mysqli_error($link);  
    } else {
        echo "По запросу: `".$findable."` не найдено записей.<br>";
    }

    function numberProblem($number) {
        $remainder = $number%10;
        if($remainder === 0 || $remainder > 4 || ($number > 10 && $number < 20)) {
            return "записей";
        } else if($remainder > 1) {
            return "записи";
        } else {
            return "запись";
        }
    }
?>
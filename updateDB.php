<!DOCTYPE html>
<html>
    <head>
    <title>Загрузка данных в БД</title>
    <meta charset = ""utf-8/>
    </head>
    <body>
        <?php
            $user = 'root';
            $password = 'root';
            $db = 'base_for_inline';
            $host = 'localhost';
            $posts_url = 'https://jsonplaceholder.typicode.com/posts';
            $comments_url = 'https://jsonplaceholder.typicode.com/comments';

            $link = mysqli_connect($host,$user,$password,$db);

            $posts_upd = updateTable($posts_url,"posts");
            $comments_upd = updateTable($comments_url,"comments");
            echo "<h3>Готово</h3>";
            echo "<form action = 'index.html'><button type = 'submit'>ОК</button></form>";
            echo "<script>console.log('Загружено ".$posts_upd." записей и ".$comments_upd." комментариев');</script>";

            function updateTable($url, $tableName) {
                global $link;
                $count = 0;

                // Получение данных из БД
                $result = mysqli_query($link,"SELECT * FROM `".$tableName."`")
                or die("SELECT trouble: ".mysqli_error($link));

                // Сохранение данных из БД в файл.
                for($tmp =[]; $row = mysqli_fetch_assoc($result); $tmp[]=$row);
                $tmp = json_encode($tmp);
                file_put_contents($tableName.".json",$tmp);

                // Очистка БД
                mysqli_query($link, "TRUNCATE TABLE ".$tableName)
                or die("TRUNCATE trouble: ".mysqli_error($link));
                
                // Подготовка запроса для добавления данных в БД
                $data = json_decode(file_get_contents($url));
                $statement = "INSERT INTO `".$tableName."` (";
                foreach($data[0] as $key=>$value) {
                    $statement.=$key.", ";
                }
                $statement = mb_substr($statement,0,-2);
                $statement.=") VALUES ";
                foreach($data as $row) {
                    $statement.="(";
                    foreach($row as $value) {
                        $statement.="'".$value."', ";
                    }
                    $statement = mb_substr($statement,0,-2);
                    $statement.="),";
                    $count++;
                }
                $statement = mb_substr($statement,0,-1);
                $statement.=";";

                // Отправка подготовленного запроса в СУБД
                mysqli_query($link,$statement)
                or die("INSERT trouble: ".mysqli_error($link));
                return $count;
            }
        ?>
    </body>
</html>
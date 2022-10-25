<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h3>Добавление поля</h3>
<form action="tender.php" method="post">
    <p>Внешний код:
    <input type="number" name="code" /></p>
    <p>Номер:
    <input type="number" name="numbers" /></p>
    <p>Статус:
    <input type="text" name="status" /></p>
    <p>Название:
    <input type="text" name="name" /></p>
    <p>Дата изменения:
    <input type="datetime-local" name="date" /></p>
    <input type="submit" value="Добавить">
</form>
<h2>Список пользователей</h2>
<form action="tender.php" method="get">
    <p>Выборка по индексу:
    <input type="number" name="id" /></p>
    <input type="submit" value="Показать">
    <p>Выборка по дате:
    <input type="text" name="time" /></p>
    <input type="submit" value="Показать">
</form>
<?php

    //Добаввление данных в бд

    $mysqli = new mysqli('localhost', 'root', '', 'Zebra');
    $file = fopen('test_task_data.csv', 'r');
    fgetcsv($file);
    while (!feof($file)) {
        $column = fgetcsv($file, 1024, ',');
        $j= count($column);
        if($j>1){
            $mysqli->query("INSERT INTO `Tender` (`code`,`numbers`,`status`,`name`,`date`) VALUES ('{$column[0]}', '{$column[1]}', '{$column[2]}', '{$column[3]}', '{$column[4]}')");
        }
    }
    fclose($file);
    $mysqli->close();

    // Добавление строки в таблицу с помощью POST запроса
    
        if (isset($_POST['code']) 
        && isset($_POST['numbers'])
        && isset($_POST['status'])
        && isset($_POST['name'])
        && isset($_POST['date'])
        ) {
      
        $conn = new mysqli('localhost', 'root', '', 'Zebra');
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $code = $conn->real_escape_string($_POST['code']);
        $numbers = $conn->real_escape_string($_POST['numbers']);
        $status = $conn->real_escape_string($_POST['status']);
        $name = $conn->real_escape_string($_POST['name']);
        $date = $conn->real_escape_string($_POST['date']);
        $sql = "INSERT INTO Tender (code,numbers,status,name,date) VALUES ('$code', '$numbers', '$status', '$name', '$date')";
        if($conn->query($sql)){
            print('</br>'.'Успепшно'.'</br>');
        } else{
            echo "Ошибка: " . $conn->error;
        }
        $conn->close();
    }

    // Получение списка тендеров по дате и тендеров по индексу

        $con = new mysqli('localhost', 'root', '', 'Zebra');
        if($con->connect_error){
            die("Ошибка: " . $con->connect_error);
        }
        $id = $con->real_escape_string($_GET['id']);
        $time = $con->real_escape_string($_GET['time']);
        $sql = "SELECT * FROM Tender WHERE `id` IN ('$id') OR `date` IN ('$time')";
        if($result = $con->query($sql)){
            $rowsCount = $result->num_rows; 
            echo "<p>Получено объектов: $rowsCount</p>";
            echo "<table><tr><th>Id</th><th>Внешний код</th><th>Номер</th><th>Статус</th><th>Название</th><th>Дата изменения</th></tr>";
            foreach($result as $row){
                echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["code"] . "</td>";
                    echo "<td>" . $row["numbers"] . "</td>";
                    echo "<td>" . $row["satus"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            $result->free();
        } else{
            echo "Ошибка: " . $con->error;
        }
        $con->close();

?> 
</body>
</html>
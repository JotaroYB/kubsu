<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/
$user = 'u20613';
$password = '1552407';

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.

if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}
else {
  $dbh = new PDO('mysql:host=localhost;dbname=u20613', $user, $password,
  array(PDO::ATTR_PERSISTENT => true));
  $sth = $dbh->prepare("SELECT adminpass FROM admindatabase WHERE adminlogin = ?");
  $sth->execute(array($_SERVER['PHP_AUTH_USER']));
  $pass_value = $sth->fetch(PDO::FETCH_COLUMN);

  if ($_SERVER['PHP_AUTH_USER'] != 'admin' || md5($_SERVER['PHP_AUTH_PW']) != $pass_value) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
}

if(isset($_GET['logout'])) {
  header('Location: http://logout@u20613.kubsu-dev.ru/kubsu/project7/admin.php');
  exit();
}

if (!empty($_GET['delete'])){
    $stmt = $dbh->prepare("DELETE FROM application WHERE id = ?");
    $stmt->execute(array($_GET['delete']));
    print("Успешно удалено!");
}

// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********

$stmt = $dbh->query("SELECT * FROM application");
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="task5style.css">
  <title>Adminka</title>
</head>
<body>
  <h1>Добро пожаловать, админ!</h1>
  <form method="GET">
  <input type="hidden" value="1" name="logout">
  <input type="submit" value="Выйти">
  </form>
    <table>
      <tr>
      	<th>id</th>
        <th>ulogin</th>
        <th>upass</th>
        <th>fio</th>
        <th>mail</th>
        <th>birthday</th>
        <th>sex</th>
        <th>limbs</th>
        <th>superskills</th>
        <th>bio</th>
        <th>checkbox</th>
      </tr>
      <tr>
      <?php 
        foreach($stmt as $row) {
        ?>
        <tr>
          	<td><?php echo $row['id'] ?></td>
            <td><?php echo $row['ulogin'] ?></td>
            <td><?php echo $row['upass'] ?></td>
            <td><?php echo $row['fio'] ?></td>
            <td><?php echo $row['mail']?></td>
            <td><?php echo $row['birthday'] ?></td>
            <td><?php echo $row['sex'] ?></td>
            <td><?php echo $row['limbs'] ?></td>
            <td><?php echo $row['superskills'] ?></td>
            <td><?php echo $row['bio'] ?></td>
            <td><?php echo $row['checkbox'] ?></td>
                
            <td><form action="" method="GET"><input type="submit"  value="Удалить данные">
            <input type="hidden" value=<?php echo $row['id']?> name="delete"></form></td>
        </tr>
        <?php
        }
        ?>        
      </tr>
    </table>
  </body>
</html>

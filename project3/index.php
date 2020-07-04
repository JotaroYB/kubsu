<html lang="en">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Задание 3</title>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
      if (!empty($_GET['save'])) {
        // Если есть параметр save, то выводим сообщение пользователю.
        print('Спасибо, результаты сохранены.');
      }
      // Включаем содержимое файла form.php.
      include('form.php');
      // Завершаем работу скрипта.
      exit();
    }
    ?>
</body>
</html>

<?php

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}
if (empty($_POST['email']) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  print('Почта либо заполнена неверно, либо не заполнена вовсе.<br/>');
  $errors = TRUE;
}
if (empty($_POST['datebirth'])) {
  print('Заполните дату рождения.<br/>');
  $errors = TRUE;
}
if (empty($_POST['superskills'])) {
  print('Заполните способности.<br/>');
  $errors = TRUE;
}
if (empty($_POST['biography'])) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}
if (empty($_POST['accept'])) {
  print('Подтвердите, что принимаете условия.<br/>');
  $errors = TRUE;
}

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

// Параметры для подключения
$db_host = "localhost"; 
$db_user = "u20613"; // Логин БД
$db_password = "1552407"; // Пароль БД
$db = "u20613"; // Имя БД

// Подключаемся к серверу
$link = mysqli_connect($db_host, $db_user, $db_password, $db) 
or die("Ошибка " . mysqli_error($link));

// Создаём таблицу, если её нет
$create_table_query = "CREATE TABLE IF NOT EXISTS application (
  id int(10) unsigned NOT NULL  AUTO_INCREMENT,
  fio varchar(128) NOT NULL DEFAULT '',
  mail varchar(128) NOT NULL DEFAULT '',
  birthday varchar(10) NOT NULL DEFAULT '',
  sex varchar(1) NOT NULL DEFAULT '',
  limbs int(1) NOT NULL DEFAULT 0,
  superskills varchar(128) NOT NULL DEFAULT '',
  bio varchar(512) NOT NULL DEFAULT '',
  checkbox varchar(2) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
)";

if(!mysqli_query($link, $create_table_query)) {
  die("Ошибка " . mysqli_error($link));
}

// Определение входных данных
$fio = $_POST['fio'];
$mail = $_POST['email'];
$birthday = strval($_POST['datebirth']);
$sex = $_POST['sex'];
$limbs = $_POST['limb'];
$superskills = implode(', ', $_POST['superskills']);
$bio = $_POST['biography'];
$checkbox = $_POST['accept'];

// Запрос на вставку данных
$insert_query = "INSERT INTO application (fio, mail, birthday, sex, limbs, superskills, bio, checkbox) VALUES ('$fio', '$mail', '$birthday', '$sex', '$limbs', '$superskills', '$bio', '$checkbox')";

if(mysqli_query($link, $insert_query)) {
  // Закрываем соединение
  mysqli_close($link);

  // Редирект
  header('Location: ?save=1');
}

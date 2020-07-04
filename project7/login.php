<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="task5style.css">
  <title>Login</title>
</head>
<body>

<?php

// Начинаем сессию.
session_start();
$val['ulogin'] = '';
$msg = array();
$err = false;

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  // при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if(!empty($_COOKIE['ulogin_err'])) {
    $err['ulogin'] =  true;
    $msg['ulogin'] = $_COOKIE['ulogin_err']; 
  }
  else {
    $val['ulogin'] = !empty($_COOKIE['ulogin_val']) ? $_COOKIE['ulogin_val'] : "";
    $err['ulogin'] = false;
  }

  if(!empty($_COOKIE['upass_err'])) {
    $err['upass'] = true;
    $msg['upass'] = $_COOKIE['upass_err'];
  }
  else {
    $err['upass'] = false;
  }

?>

<form action="" method="post">
  <div class="input-block margin-bottom">
    <label for="login">Логин</label>
    <input name="login" class="border-radius" type="text" value=<?php print $val['ulogin']; ?>>
    <?php if ($err['ulogin']) {print '<p class="err-msg">'.$msg['ulogin'].'</p>'; } ?>
  </div>
  <div class="input-block margin-bottom">
    <label for="pass">Пароль</label>
    <input name="pass" class="border-radius" type="password">
  </div>
  <?php if ($err['upass']) {print '<p class="err-msg">'.$msg['upass'].'</p>'; } ?>
  <button class="border-radius margin-bottom" name="come">Войти</button>
  <br>
  <a class="linked_btn" href="index.php">На главную</a>
</form>

<?php
}
else {
  
  $err = false;

  if(empty($_POST['login'])) {
    $err['ulogin'] = true;
    setcookie("ulogin_err", "Логин не указан", time() + 24 * 60 * 60);
  }
  else {
    setcookie("ulogin_val", $_POST['login'], time() + 24 * 60 * 60);
    setcookie("ulogin_err", "", 100000);
  }
  
  if(empty($_POST['pass'])) {
    $err['upass'] = true;
    setcookie("upass_err", "Пароль не указан", time() + 24 * 60 * 60);
  }
  else {
    setcookie("upass_err", "", 100000);
  }

  if(!$err) {
    $user = 'u20613';
    $password = '1552407';
    $dbh = new PDO('mysql:host=localhost;dbname=u20613', $user, $password,
        array(PDO::ATTR_PERSISTENT => true));
    $sth = $dbh -> prepare("SELECT upass FROM application WHERE ulogin = ?");
    $sth -> execute(array($_POST['login']));
    $value = $sth -> fetch(PDO::FETCH_COLUMN);

    if ($value != md5($_POST['pass'])) {
      $err['upass'] = true;
      setcookie("upass_err", "Вы ввели некорректный пароль", time() + 24 * 60 * 60);
      header('Location: login.php');
      exit();
    }

    setcookie("ulogin_val", "", 100000);

    // Если все ок, то авторизуем пользователя.
    $_SESSION['login'] = $_POST['login'];
  
    // Делаем перенаправление.
    header('Location: index.php');
  }
  else {
    header('Location: login.php');
  }

}
?>
</body>
</html>

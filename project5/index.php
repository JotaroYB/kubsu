<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="task5style.css">
  <title>Project 5</title>
</head>
<body>
<?php


// Массив супервозможностей
$superskills = ['godmode' => 'Бессмертие', 'noclip' => 'Хождение сквозь стены', 'flymod' => 'Левитация']; 

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save']) || !empty($_COOKIE['update'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 10000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    setcookie('update', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages['success'] = '<div style="background-color: green; color: white; padding: 10px 20px; border-radius: 40px; margin: 20px">';
    $messages['success'] .= 'Спасибо, результаты сохранены.';
    if (!empty($_COOKIE['pass'])) {
      $messages['success'] .= '<div> Вы можете <a href="login.php">войти</a> с логином <strong>'.$_COOKIE["login"].'</strong> и паролем <strong>'.$_COOKIE["pass"].'</strong> для изменения данных. </div>';
    }
    $messages['success'] .= '</div>';
    
    print($messages['success']);
    
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['datebirth'] = !empty($_COOKIE['datebirth_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['superskills'] = !empty($_COOKIE['superskills_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['accept'] = !empty($_COOKIE['accept_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages['fio'] = 'Заполните имя, используя только буквы';
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages['email'] = 'Заполните почту правильно';
  }
  if ($errors['datebirth']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('datebirth_error', '', 100000);
    // Выводим сообщение.
    $messages['datebirth'] = 'Заполните полностью дату рождения';
  }
  if ($errors['sex']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('sex_error', '', 100000);
    // Выводим сообщение.
    $messages['sex'] = 'Укажите пол';
  }
  if ($errors['limb']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limb_error', '', 100000);
    // Выводим сообщение.
    $messages['limb'] = 'Укажите количество конечностей';
  }
  if ($errors['superskills']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('superskills_error', '', 100000);
    // Выводим сообщение.
    $messages['superskills'] = 'Выберите хотя бы одну суперспособность';
  }
  if ($errors['biography']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    // Выводим сообщение.
    $messages['biography'] = 'Заполните биографию';
  }
  if ($errors['accept']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('accept_error', '', 100000);
    // Выводим сообщение.
    $messages['accept'] = 'Вам необходимо согласиться с условиями';
  }

  // массив данных
  $values = array();

  // если нет ошибок, стартовала сессия и есть логин, то выгружаем данные в массив $array
  if (session_start() && !empty($_SESSION['login'])) {

    // Параметры для подключения
    $db_user = "u20613"; // Логин БД
    $db_password = "1552407"; // Пароль БД
    
    // Подключаемся к БД
    $db = new PDO('mysql:host=localhost;dbname=u20613', $db_user, $db_password,
    array(PDO::ATTR_PERSISTENT => true));
    $sth = $db -> prepare("SELECT * FROM application WHERE ulogin = ?");
    $sth -> execute(array($_SESSION['login']));
    $res = $sth -> fetch(PDO::FETCH_ASSOC);
    
    // Выгружаем данные
    $values['fio'] = $res["fio"];
    $values['email'] = $res["mail"];
    $values['datebirth'] = $res["birthday"];
    $values['sex'] = $res["sex"];
    $values['limb'] = $res["limbs"];
    $values['biography'] = $res["bio"];
    $values['acсept'] = $res["checkbox"];

    foreach(explode(', ', $res["superskills"]) as $skill) {
      $values['superskills'][$skill] = $skill;
    }
  }

  // иначе берём данные из куки
  else {
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['datebirth'] = empty($_COOKIE['datebirth_value']) ? '' : $_COOKIE['datebirth_value'];
    $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
    $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['accept'] = empty($_COOKIE['accept_value']) ? '' : $_COOKIE['accept_value'];
    
    if(!empty($_COOKIE['superskills_value'])) {
      $ssCoockie = json_decode($_COOKIE['superskills_value']);
      if(is_array($ssCoockie)) {
        foreach($ssCoockie as $skill) {
          $values['superskills'][$skill] = $skill;
        }
      }
    }
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их.
else {
  // Проверяем ошибки.
  $errors = FALSE;

  //Проверка ФИО 
  $fio_pattern = '/^[a-zA-Zа-яА-Я]+$/u';
  if (preg_match($fio_pattern, $_POST['fio']) == 0) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('fio_value', $_POST['fio'], time() + 12 * 30 * 24 * 60 * 60);
    $fio = $_POST['fio'];
  }

  //Проверка почты 
  $email_pattern = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';
  if (preg_match($email_pattern, $_POST['email']) == 0) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
    $mail = $_POST['email'];
  }

  //Проверка даты рождения 
  if (empty($_POST['datebirth'])) {
    // Выдаем куку на день с флажком об ошибке в поле datebirth.
    setcookie('datebirth_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('datebirth_value', $_POST['datebirth'], time() + 12 * 30 * 24 * 60 * 60);
    $birthday = strval($_POST['datebirth']);
  }

  //Проверка пола
  if (empty($_POST['sex'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('sex_value', $_POST['sex'], time() + 12 * 30 * 24 * 60 * 60);
    $sex = $_POST['sex'];
  }

  //Проверка конечностей
  if (empty($_POST['limb'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('limb_value', $_POST['limb'], time() + 12 * 30 * 24 * 60 * 60);
    $limbs = $_POST['limb'];
  }

  //Проверка суперспособностей 
  if (empty($_POST['superskills'])) {
    // Выдаем куку на день с флажком об ошибке в поле superskills.
    setcookie('superskills_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    $selectedSkills = json_encode($_POST['superskills']); // Кодируем входящий массив в строку JSON
    setcookie('superskills_value', $selectedSkills, time() + 12 * 30 * 24 * 60 * 60);
    $superskills = implode(', ', $_POST['superskills']);
  }

  //Проверка биографии 
  if (empty($_POST['biography'])) {
    // Выдаем куку на день с флажком об ошибке в поле biography.
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('biography_value', $_POST['biography'], time() + 12 * 30 * 24 * 60 * 60);
    $bio = $_POST['biography'];
  }

  //Проверка аксепта  
  if (empty($_POST['accept'])) {
    // Выдаем куку на день с флажком об ошибке в поле accept.
    setcookie('accept_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('accept_value', $_POST['accept'], time() + 12 * 30 * 24 * 60 * 60);
    $checkbox = $_POST['accept'];
  }

  // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('datebirth_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limb_error', '', 100000);
    setcookie('superskills_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('accept_error', '', 100000);
  }

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
  // TODO: перезаписать данные в БД новыми данными,
  // кроме логина и пароля.
    $user = 'u20613';
    $password = '1552407';
    $db = new PDO('mysql:host=localhost;dbname=u20613', $user, $password,
        array(PDO::ATTR_PERSISTENT => true));
      
    //////
    try {
        $stmt = $db -> prepare("UPDATE application SET fio = ?, mail = ?, birthday = ?, sex = ?, limbs = ?, superskills = ?, bio = ?, checkbox = ? WHERE ulogin = ?");
        $stmt -> execute([$_POST['fio'], $_POST['email'], $_POST['datebirth'] , $_POST['sex'], $_POST['limb'],  implode(', ', $_POST['superskills']), $_POST['biography'], $_POST['accept'], $_SESSION['login']  ] );
        setcookie('update', '1', time() + 12 * 30 * 24 * 60 * 60);
        header('Location: index.php');
      }
    catch(PDOException $e){
        print('Error : ' . $e -> getMessage());
        exit();
    }
  }
  
  // Сохраняем в базу
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
      ulogin varchar(5) NOT NULL DEFAULT '',
      upass varchar(128) NOT NULL DEFAULT '',
      fio varchar(128) NOT NULL DEFAULT '',
      mail varchar(128) NOT NULL DEFAULT '',
      birthday varchar(10) NOT NULL DEFAULT '',
      sex varchar(1) NOT NULL DEFAULT '',
      limbs int(1) NOT NULL DEFAULT 0,
      superskills varchar(128) NOT NULL DEFAULT '',
      bio varchar(512) NOT NULL DEFAULT '',
      checkbox varchar(6) NOT NULL DEFAULT '',
      PRIMARY KEY (id)
    )";
  
  if(!mysqli_query($link, $create_table_query)) {
    die("Ошибка " . mysqli_error($link));
  }
  
  
  // $editable = FALSE;
  
  if (empty($_SESSION['login'])) {
    $login = substr(md5(uniqid(rand(),1)), 0, 5);
    $pass = substr(md5(rand()), 0, 8);
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $pass);
    // Определение входных данных
    $hash_pass = md5($pass);
    // Запрос на вставку данных
    $insert_query = "INSERT INTO application (fio, ulogin, upass, mail, birthday, sex, limbs, superskills, bio, checkbox) VALUES ('$fio', '$login','$hash_pass', '$mail', '$birthday', '$sex', '$limbs', '$superskills', '$bio', '$checkbox')";
    
    if(mysqli_query($link, $insert_query)) {
      // Закрываем соединение
      mysqli_close($link);
      
      setcookie('save', '1', time() + 12 * 30 * 24 * 60 * 60);
      // Редирект
      header('Location: index.php');
    } 
  }
}

?>
</body>
</html>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ФОРМА</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php  
    if (!empty($messages)) {
      print('<div class="messages">');
      foreach ($messages as $message) {
        print($message);
      }
      print('</div>');
    }
  ?>

  <div class="container">
    <h2>Форма</h2>
    <form action="" method="POST">
      Имя:<br><input type="text" name="names" <?php if ($errors['names']) {print 'class="group error"';} else print 'class="group"'; ?> value="<?php print $values['names']; ?>">
      <br>
      Телефон:<br><input type="tel" name="phone" <?php if ($errors['phone']) {print 'class="group error"';} else print 'class="group"'; ?> value="<?php print $values['phone']; ?>">
      <br>
      E-mail:
        <br><input type="text" name="email" <?php if ($errors['email']) {print 'class="group error';} else print 'class="group"'; ?> value="<?php print $values['email']; ?>"><br>
      Дата рождения:
      <div class="form-group">
        <input type="date" id="data" size="3" name="data" <?php if ($errors['data']) {print 'class="group error"';} else print 'class="group"';?> value="<?php print $values['data']; ?>">
      </div>
      <div <?php if ($errors['gender']) {print 'class="error"';} ?>>
        Пол:<br>
        <input class="radio" type="radio" name="gender" value="M" <?php if ($values['gender'] == 'M') {print 'checked';} ?>> Мужской
        <input class="radio" type="radio" name="gender" value="W" <?php if ($values['gender'] == 'W') {print 'checked';} ?>> Женский
      </div>
      Любимый язык программирования:<br>
      <select class="group" name="languages[]" size="10" multiple>
        <option value="Pascal" <?php if (in_array("Pascal", $values['language'])) {print 'selected';} ?>>Pascal</option>
        <option value="C" <?php if (in_array("C", $values['language'])) {print 'selected';} ?>>C</option>
        <option value="C_plus_plus" <?php if (in_array("C++", $values['language'])) {print 'selected';} ?>>C++</option>
        <option value="JavaScript" <?php if (in_array("JavaScript", $values['language'])) {print 'selected';} ?>>JavaScript</option>
        <option value="PHP" <?php if (in_array("PHP", $values['language'])) {print 'selected';} ?>>PHP</option>
        <option value="Python" <?php if (in_array("Python", $values['language'])) {print 'selected';} ?>>Python</option>
        <option value="Java" <?php if (in_array("Java", $values['language'])) {print 'selected';} ?>>Java</option>
        <option value="Haskel" <?php if (in_array("Haskel", $values['language'])) {print 'selected';} ?>>Haskel</option>
        <option value="Clojure" <?php if (in_array("Clojure", $values['language'])) {print 'selected';} ?>>Clojure</option>
        <option value="Prolog" <?php if (in_array("Prolog", $values['language'])) {print 'selected';} ?>>Prolog</option>
      </select>
      <br>
      Биография:<br><textarea class="group" name="biography" rows="3" cols="30"><?php print $values['biography']; ?></textarea>
      <div  <?php if ($errors['agree']) {print 'class="error"';} ?>>
        <input type="checkbox" name="agree" <?php if ($values['agree']) {print 'checked';} ?> value="1"> С контрактом ознакомлен(a) 
      </div>
      <input type="submit" id="send" value="ОТПРАВИТЬ">
    </form>
  </div>
  
  <div class="container">
    <?php
      if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
        print('<a href="login.php" class = "enter-exit" title = "Log out">Выйти</a>');
      else
        print('<a href="login.php" class = "enter-exit"  title = "Log in">Войти</a>');
    ?>
  </div>
</body>
</html>
<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены. ';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
    }
    $errors = array();
    $errors['names'] = !empty($_COOKIE['name_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['data'] = !empty($_COOKIE['data_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['agree'] = !empty($_COOKIE['agree_error']);

    if ($errors['names']) {
        setcookie('names_error', '', 100000);
        $messages[] = '<div>Заполните имя.</div>';
    }
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        $messages[] = '<div>Некорректный телефон.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div>Некорректный email.</div>';
    }
    if ($errors['data']) {
        setcookie('data_error', '', 100000);
        $messages[] = '<div>Выберите год рождения.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = '<div>Выберите пол.</div>';
    }
    if ($errors['agree']) {
        setcookie('agree_error', '', 100000);
        $messages[] = '<div>Поставьте галочку.</div>';
    }
    $values = array();
$values['names'] = isset($_COOKIE['names_value']) ? strip_tags($_COOKIE['names_value']) : '';
$values['phone'] = isset($_COOKIE['phone_value']) ? strip_tags($_COOKIE['phone_value']) : '';
$values['email'] = isset($_COOKIE['email_value']) ? strip_tags($_COOKIE['email_value']) : '';
$values['data'] = isset($_COOKIE['data_value']) ? $_COOKIE['data_value'] : '';
$values['gender'] = isset($_COOKIE['gender_value']) ? $_COOKIE['gender_value'] : '';
$values['biography'] = isset($_COOKIE['biography_value']) ? strip_tags($_COOKIE['biography_value']) : '';
$values['agree'] = isset($_COOKIE['agree_value']) ? $_COOKIE['agree_value'] : ''; 
if (empty($_COOKIE['language_value'])) {
        $values['language'] = array();
    } else {
        $values['language'] = json_decode($_COOKIE['language_value'], true);  
    }
    $language = isset($language) ? $language : array();
    if (!empty($_SESSION['login'])) {
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
}
    session_start();
    if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        $db = new PDO('mysql:host=localhost;dbname=u67439', 'u67439', '4415842', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("SELECT * FROM application WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $values['names'] = strip_tags($row['names']);
        $values['phone'] = isset($_COOKIE['phone']) ? strip_tags($_COOKIE['phone']) : '';
        $values['email'] = strip_tags($row['email']);
        $values['data'] = isset($_COOKIE['data']) ? $_COOKIE['data'] : '';
        $values['gender'] = $row['gender'];
        $values['biography'] = strip_tags($row['biography']);
        $values['agree'] = true; 
        $stmt = $db->prepare("SELECT * FROM languages WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $ability = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $values['language'] = isset($_COOKIE['language_value']) ? json_decode($_COOKIE['language_value'], true) : array();
        }
        $values['language'] = $language;
        printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
    }
    include('form.php');
}
else {
    $errors = FALSE;
    if (empty(htmlentities($_POST['names']))) {
        setcookie('names_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('names_value', $_POST['names'], time() + 12 * 30 * 24 * 60 * 60);
    }
    if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $_POST['phone'])) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
    }
    if (empty($_POST['data'])) {
        setcookie('data_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('data_value', $_POST['data'], time() + 12 * 30 * 24 * 60 * 60);
    }
    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 12 * 30 * 24 * 60 * 60);
    }
    if (empty($_POST['agree'])) {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('agree_value', $_POST['agree'], time() + 12 * 30 * 24 * 60 * 60);
    }
    if (isset($_POST['language'])) {
        $language = $_POST['language'];
    } else {
        $language = array(); 
    }
    if (!empty($_POST['biography'])) {
        setcookie ('biography_value', $_POST['biography'], time() + 12 * 30 * 24 * 60 * 60);
    }
    if (!empty($_POST['language'])) {
        $json = json_encode($_POST['language']);
        setcookie ('language_value', $json, time() + 12 * 30 * 24 * 60 * 60);
    }

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('names_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('data_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('agree_error', '', 100000);
    }
    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {
        $db = new PDO('mysql:host=localhost;dbname=u67394', 'u67394', '4866541', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("UPDATE application SET names = ?, phones = ?, email = ?, data = ?, gender = ?, biography = ? WHERE id = ?");
        $stmt->execute([$_POST['names'], $_POST['phone'], $_POST['email'], $_POST['data'], $_POST['gender'], $_POST['biography'], $_SESSION['uid']]);
        $stmt = $db->prepare("DELETE FROM languages WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $ability = $_POST['language'];
        foreach ($language as $item) {
            $stmt = $db->prepare("INSERT INTO application_languages SET id = ?, name_of_language = ?");
            $stmt->execute([$_SESSION['uid'], $item]);
        }
    } else {
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $max=rand(8,16);
        $size=StrLen($chars)-1;
        $pass=null;
        while($max--)
            $pass.=$chars[rand(0,$size)];
        $login = $chars[rand(0,25)] . strval(time());
        setcookie('login', $login);
        setcookie('pass', $pass);
        $db = new PDO('mysql:host=localhost;dbname=u67394', 'u67394', '4866541', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("INSERT INTO application SET names = ?, phones = ?, email = ?, dates = ?, gender = ?, biography = ?");
        $stmt->execute([$_POST['names'], $_POST['phone'], $_POST['email'], $_POST['data'], $_POST['gender'], $_POST['biography']]);
        $res = $db->query("SELECT max(id) FROM application");
        $row = $res->fetch();
        $count = (int) $row[0];
        $ability = $_POST['language'];
        foreach ($language as $item) {

$stmt = $db->prepare("INSERT INTO application_languages SET id = ?, name_of_language = ?");
            $stmt->execute([$count, $item]);
        }
        $stmt = $db->prepare("INSERT INTO login_pass SET id = ?, login = ?, pass = ?");
        $stmt->execute([$count, $login, md5($pass)]);
    }
    setcookie('save', '1');
    header('Location: ./');
}
?>



<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Вход в систему</title>
</head>

<body>
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if (!empty($_SESSION['login'])) {
  session_destroy();
  header('Location: ./');
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (!empty($_GET['nologin']))
    print("<div>Пользователя с таким логином не существует</div>");
  if (!empty($_GET['wrongpass']))
    print("<div>Неверный пароль!</div>");

?>
  <form action="" method="post">
    <input name="login" placeholder="Введи логин"/>
    <input name="pass" placeholder="Введи пароль"/>
    <input type="submit" id="login" value="Войти" />
  </form>

  <?php
}
else {
  $db = new PDO('mysql:host=localhost;dbname=u67394', 'u67394', '4866541', array(PDO::ATTR_PERSISTENT => true));
  $stmt = $db->prepare("SELECT id, pass FROM login_pass WHERE login = ?");
  $stmt -> execute([$_POST['login']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$row) {
    header('Location: ?nologin=1');
    exit();
  }
  if($row["pass"] != md5($_POST['pass'])) {
    header('Location: ?wrongpass=1');
    exit();
  }
  $_SESSION['login'] = $_POST['login'];
  $_SESSION['uid'] = $row["id"];
  header('Location: ./');
}

?>

</body>

</html>
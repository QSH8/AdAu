<?php
    require 'backend/db.php';

    $data = $_POST;
    if (isset($data['do_auth'])) {
        $errors = array(); // валидация
        $user = R::findOne('users', 'login = ?', array($data['login']));
        
        if (trim($data['login']) == '') {
            $errors[] = 'Введите Ваш логин';  // Проверка на пустоту
        } 
        if ($data['password'] == '') {
            $errors[] = 'Введите Ваш пароль';
        } 

        if ($user) {
            if ( (password_verify($data['password'], $user->password)) ) {
                $_SESSION['logged_user'] = $user;
                $isAuth = isset($_SESSION['logged_user']);
            } else {
                $errors[] = 'Пароль введён неверно';
            }
        } else {
            $errors[] = 'Пользователя с таким логином не существует';   // Проверка на соответствие
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/index.css">
    <title>AdAurumCompanies</title>
</head>
<body>
    <header class="header">

    <div class="header__logo"></div>

    <div class="header__nav">

        <div id="companies" class="header__nav-item">
            <div class="header__nav-item-btn"><a href="http://localhost/AdAurum/index.php">Компании</a></div>
        </div>
        <?php if (isset($_SESSION['logged_user'])) {
            echo '<a href="logout.php">
                    <div id="sign" class="header__nav-item">
                
                        <div class="header__nav-item-text">Выйти</div>
                        <img class="header__nav-item-icon" src="./icons/auth.png" alt="">
                    </div>
                  </a>';
        } else {
            echo '<div class="header__nav-item-wrapper">
                    <a href="auth.php">
                        <div id="sign" class="header__nav-item">
                    
                            <div class="header__nav-item-text">Войти</div>
                            <img class="header__nav-item-icon" src="./icons/auth.png" alt="">
                        </div>
                    </a>
                    <a href="registration.php">
                        <div id="reg" class="header__nav-item">
                            <div class="header__nav-item-text">Регистрация</div>
                            <img class="header__nav-item-icon" src="./icons/registration.png" alt="">
                        </div>
                    </a>
                  </div>';
        }?>
        
    </div>

    </header>
    <form id="auth" class="form" method="post">
    <div class="form__error-message">
        <?php 
            if (!empty($errors)) {
                echo '<p style="color: rgb(255, 83, 83)">' . array_shift($errors) . '</p>';
            } else if (isset($user)){
                echo '<p style="color: green">' . 'Вы успешно вошли!' . '</p>';
            }
        ?>
    </div>
    <label class="form__title">Вход в учётную запись</label>
    <input name="login" type="text" placeholder="Введите Ваш логин" class="form__input" value="<?php echo @$data['login']?>">
    <input name="password" type="password" placeholder="Введите Ваш пароль" class="form__input" value="<?php echo @$data['password']?>">
    <input name="do_auth" type="submit" class="form__submit" value="Войти">
</form>
<script type="module" src="./scripts/registration.js"></script>
</body>
</html>
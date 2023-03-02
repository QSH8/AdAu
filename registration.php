<?php
    require 'backend/db.php';

    $data = $_POST;
    if (isset($data['do_registration'])) {
        // регистрация

        $errors = array(); // валидация
        if (trim($data['login']) == '') {
            $errors[] = 'Введите логин';
        }
        if ($data['password'] == '') {
            $errors[] = 'Введите пароль';
        }
        if ($data['password'] != $data['password_check']) {
            $errors[] = 'Пароли не совпадают';
        }
        if (R::count('users', 'login = ?', array($data['login'])) > 0) {
            $errors[] = 'Пользователь с таким логином уже зарегистрирован';
        }
        if (empty($errors)) {
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT) ;
            R::store($user);
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

        <div class="header__nav-item-wrapper">
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
        </div>    
    </div>

    </header>
    <form id="registration" class="form" method="post">
        <div class="form__error-message">
            <?php
                
                if (!empty($errors)) {
                    echo '<p style="color: rgb(255, 83, 83)">' . array_shift($errors) . '</p>';
                } else if (isset($user)) {
                    echo '<p style="color: green">' . 'Вы успешно зарегистрировались!' . '</p>';
                }
                
            ?>
        </div>
        <label class="form__title">Регистрация учётной записи</label>
        <input name="login" type="text" placeholder="Введите логин" class="form__input" value="<?php echo @$data['login']?>">
        <input name="password" type="password" placeholder="Введите пароль" class="form__input" value="<?php echo @$data['password']?>">
        <input name="password_check" type="password" placeholder="Введите пароль ещё раз" class="form__input" value="<?php echo @$data['password_check']?>">
        <input name="do_registration" type="submit"  class="form__submit" value="Зарегистрироваться">
    </form>
<script type="module" src="./scripts/registration.js"></script>
</body>
</html>
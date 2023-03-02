<?php
    require 'backend/db.php';

    $data = $_POST;
    if (isset($data['add_company'])) {
        

        $errors = array(); // валидация
        if ($data['title'] == '') {
            $errors[] = 'Введите название';
        }
        if ($data['tin'] == '') {
            $errors[] = 'Введите ИНН';
        }
        if ($data['info'] == '') {
            $errors[] = 'Введите информацию';
        }
        if ($data['ceo'] == '') {
            $errors[] = 'Введите ФИО ГенДира';
        }
        if ($data['phone'] == '') {
            $errors[] = 'Введите телефон';
        }
        if ($data['address'] == '') {
            $errors[] = 'Введите адрес';
        }
        if (R::count('companies', 'title = ?', array($data['title'])) > 0) {
            $errors[] = 'Компания с таким названием уже зарегистрирована';
        }
        if (empty($errors)) {
            $company = R::dispense('companies');
            $company->title = $data['title'];
            $company->TIN = $data['tin'];
            $company->info = $data['info'];
            $company->CEO = $data['ceo'];
            $company->phone = $data['phone'];
            $company->address = $data['address'];
            R::store($company);
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
            <?php  if (isset($_SESSION['logged_user'])) {
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
    <form id="add_company" class="form form_add-company" method="post">
    <div class="form__message">
        <?php
            
            if (!empty($errors)) {
                echo '<p style="color: rgb(255, 83, 83)">' . array_shift($errors) . '</p>';
            } else if (isset($company)) {
                echo '<p style="color: green">' . 'Компания добавлена!' . '</p>';
            }
            
        ?>
    </div>
    <label class="form__title">Добавление новой компании</label>
    <input name="title" type="text" placeholder="Введите название компании" class="form__input" value="<?php echo @$data['title']?>">
    <input name="tin" type="text" placeholder="Введите ИНН" class="form__input" value="<?php echo @$data['tin']?>">
    <input name="info" type="text" placeholder="Введите основную информацию о компании" class="form__input" value="<?php echo @$data['info']?>">
    <input name="ceo" type="text" placeholder="Введите ФИО генерального директора" class="form__input" value="<?php echo @$data['ceo']?>">
    <input name="phone" type="text" placeholder="Введите номер телефона для связи с компанией" class="form__input" value="<?php echo @$data['phone']?>">
    <input name="address" type="text" placeholder="Введите адрес компании" class="form__input" value="<?php echo @$data['address']?>">
    <input name="add_company" type="submit" class="form__submit" value="Добавить">
</form>
<script type="module" src="./scripts/script.js"></script>
</body>
</html>
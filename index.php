<?php
    require 'backend/db.php';
    $companies = R::findAll('companies');

    if (isset($_POST['do_delete']) and !$companies == null) {
        $companyTitle = $_POST['do_delete'];
        $company_to_delete = R::findOne('companies', 'title = ?', array($companyTitle));
        R::trash($company_to_delete);
        header('Location: http://localhost/AdAurum/');
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
    <main class="main">
        <div class="main__content">
            <?php foreach($companies as $company) {
                echo    '<div class="main__content-item" style="display: block;">';
                        if(isset($_SESSION['logged_user'])) {
                            echo '<form class="main__btn-delete" method="post">
                                    <button name="do_delete" type="submit" value="'.$company['title'].'"></button>
                                    </form>';
                        }
                        
                echo    '<form action="company.php" method="post">
                            <input class="main__content-item-show" type="submit" name="show_company" value="'.$company['title'].'">
                        </form>
                            <p class="main__content-item-text">'.$company['address'].'</p>
                            <p class="main__content-item-text">'.$company['phone'].'</p>
                            <p class="main__content-item-text">'.$company['CEO'].'</p>
                        </div>';
            }?>
            <?php if (isset($_SESSION['logged_user'])) {
                echo '<div class="main__add-company">
                        <a class="main__add-company-btn" href="addCompany.php">
                            Новая компания
                        </a>
                      </div>';
            }?>
        </div>
    </main>
<script src="./scripts/script.js"></script>
</body>
</html>
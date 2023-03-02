<?php
    require 'backend/db.php'; 
    $companies = R::findAll('companies');
    
    if (isset($_POST['show_company']) and $companies != null) {
        $companyTitle = $_POST['show_company'];
        $column_names = array(
            'ID',
            'Название',
            'ИНН',
            'Общая информация',
            'Генеральный директор',
            'Адрес',
            'Телефон'
        );
        $company_to_show = R::findOne('companies', 'title = ?', array($companyTitle));
    }
    function comment($text, $column_to_comment) {
        if(isset($_SESSION['logged_user'])) {

            return
            '<div id="'.$_POST['show_company'].'" class="main__content-comment-item">
                <form id="'.$column_to_comment.'" name="comment" method="post" action="comment.php" class="main__content-comment-form hidden">

                    <textarea name="comment_text" class="main__content-comment-textarea" placeholder="Введите Ваш комментарий.." ></textarea>
                    
                    <button id="button_tag" name="comment_submit" type="submit" class="main__content-comment-btn">Добавить</button>
                
                </form>
                <p id="paragraph_tag" class="main__content-comment-text">'.$text.'</p>
                <img class="main__content-comment-icon" style="width: 20px; height: 20px;" src="./icons/comment.png" alt="X">
            </div>';
        }
    }
    function showComment($company_name, $column) {
        $comments = R::find('comments', 'company = ? AND column_to_comment = ?', [$company_name, $column]);
        if (isset($comments)) {
            return $comments;
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
    <script src="./libraries/jquery-min.js"></script>
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
            <?php if(isset($company_to_show)) {
                
                foreach ($company_to_show as $key => $value) {
                    $comments = showComment($companyTitle, $key);

                    if($key != 'id') {
                        echo '<div class="main__content-item" style="width: 100%;'; if(!isset($_SESSION['logged_user'])) echo 'justify-content: start;'; echo 'padding: 20px 0">
                                '.comment('Прокомментировать', $key).'
                                <div id="wrapper_'.$key.'">
                                    <p class="main__content-item-title">'.next($column_names).'</p>
                                    <p id="before_comments" class="main__content-item-text">'.$value.'</p>';
                                    
                                    if(isset($_SESSION['logged_user'])) {
                                        
                                        foreach (array_reverse($comments) as $comment) {
                                            echo '<p id="comment_'.$key.'" class="main__content-item-comment">
                                                '.$comment['datetime'].'
                                                    <span style=" color: rgba(255, 174, 0, 0.911);">
                                                    '.$comment['user'].':
                                                    </span>
                                                '.$comment['comment'].'
                                                </p>';
                                        }
                                        echo '<p id="comment_'.$key.'" class="main__content-item-comment"></p>';
                                            
                                    };
                        echo   '</div>
                              </div>';
                    }
                }
            }
            if(isset($_SESSION['logged_user'])) {
                $comments = showComment($companyTitle, 'company');
                echo '<div id="company_comment1" class="main__content-item main__content-comment" style="width: 100%; padding: 20px 0">
                        '.comment('Прокомментировать компанию', 'company');
                        echo '<div id="wrapper_company">';                   
                        foreach (array_reverse($comments) as $comment) {
                            echo '<p id="comment_company'.$key.'" class="main__content-item-comment">
                                '.$comment['datetime'].'
                                    <span style=" color: rgba(255, 174, 0, 0.911);">
                                    '.$comment['user'].':
                                    </span>
                                '.$comment['comment'].'
                                </p>';
                        }
                        echo '</div>';

                        
            }
            ?>
        </div>
    </main>
<script src="./scripts/script.js"></script>
</body>
</html>
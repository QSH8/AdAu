<?php
    require 'backend/db.php';    
    if (isset($_POST['formValue'])) {
        $comment = R::dispense('comments');

        $comment->company = $_POST['company_title'];
        $comment->column_to_comment = $_POST['column_to_comment'];
        $comment->user = $_SESSION['logged_user']['login'];
        $comment->comment = $_POST['formValue'];
        $comment->datetime = date('d.m.Y H:i:s');
        R::store($comment);

        echo          date('d.m.Y H:i:s').'
                <span style="color: rgba(255, 174, 0, 0.911);">
                    '.$_SESSION['logged_user']['login'].'
                </span>
                  : '.$_POST['formValue'];

    } else {
        echo "Something going bad..((";
    }
?>

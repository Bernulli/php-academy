<?php

session_start();

require_once 'blog_records.php';

$f = new blog();

if(isset($_POST['textarea']))
{
    $f->getMess($_POST['textarea']);
    $f->toDataBase();
    header ("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

if(isset($_POST['delete']) && isset($_POST['txt_delete']))
{
    $f->deleteRecord($_POST['txt_delete']);
    header ("Location: {$_SERVER['PHP_SELF']}");
}

if(isset($_POST['edit']) && isset($_POST['edit_txt']))
{
    $f->editRecord($_POST['edit_txt'], date('Y-m-d H:i:s'), $_POST['edit']);
    header ("Location: {$_SERVER['PHP_SELF']}");
}

if(isset($_POST['comment']))
{
    $from = (int)$_POST['comment_from'];
    $to = (int)$_POST['comment_to'];
    $f->addCommentToRecord($_SESSION['user'], date('Y-m-d H:i:s'), $_POST['comment'],
                            $from, $to);
    header ("Location: {$_SERVER['PHP_SELF']}");
}

?>

<?php
require_once 'header.php';
?>

<div class="container-mid">
   <?php if(isset($_SESSION['user'])):?>
      <form action="blog.php" method="post">
         <p>Повідомлення</p>
         <p>
           <textarea name="textarea" cols="179" rows="5"></textarea>
         </p>
         <input type="submit" value="Відправити">
     </form>
     <hr>
   <?endif;?>
   <?php foreach ($f->getBlogRecordings() as $item):?>
     <div class="messages">
       <p>Автор: <?=$item['author'] . "\t"?>| Дата: <?=$item['datetime']?></p>
       <hr>
         <div><?=$item['txt']?></div>
         <br>
         <?php foreach($f->getCommentRecordings() as $comm): ?>
            <?php if($item['blog_id'] == $comm['blog_id']): ?>
             <div class="messages">
                 <p>Коментар від:<?= "\t" . $comm['comment_author'] . "\t"?>| Дата: <?=$comm['comment_date']?></p>
                 <hr>
                 <?= $comm['comment_txt'] . '<br>' ?>
             </div>
            <?php endif; ?>
         <?php endforeach; ?>
       <?php if(isset($_SESSION['user']) && $_SESSION['user'] == $item['author']):?>
       <form action="blog.php" method="post">
          <input type="hidden" name="edit" value="<?=$item['datetime']?>">
          <input type="text" name="edit_txt"><br>
          <input type="submit" value="Редагувати">
       </form>
       <br>
       <form action="blog.php" method="post">
          <input type="hidden" name="delete" value="yes">
          <input type="hidden" name="txt_delete" value="<?=$item['txt']?>">
          <input type="submit" value="Видалити">
       </form>
       <?php elseif(isset($_SESSION['user']) && $_SESSION['user'] != $item['author']):?>
       <form action="blog.php" method="post">
<!--           Comment to-->
           <input type="hidden" name="comment_to" value="<?=$item['blog_id']?>">
           <?php foreach($f->getUser() as $val):;?>
           <?php if($val[1] == $_SESSION['user']):;?>
<!--           Comment from-->
           <input type="hidden" name="comment_from" value="<?=$val[0]?>">
            <?php endif;?>
           <?php endforeach;?>
           <input type="text" name="comment"><br>
           <input type="submit" value="Коментувати">
       </form>
       <?endif;?>
       </div>
   <?php endforeach; ?>
</div>

<?php
require_once 'footer.php';
?>
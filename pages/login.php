<?php

session_start();

require_once 'dbase.php';

class makeEnter extends dataBase
{
    public $login;
    private $password;
    private $token;
    private $errors = [];

    public function makeLog($log, $pass)
    {
        if(isset($_POST['log_ok']))
        {
            if($log == '')
            {
                $this->errors[] = 'Введіть логін';
            }
            else
            {
                $this->login = $log;
            }

            if($pass == '')
            {
                $this->errors[] = 'Введіть пароль';
            }
            else
            {
                $this->token = hash('ripemd128', "$pass");
                $this->password = $this->token;
            }

            if($this->uniqueUserName($this->login) != $this->login)
            {
                $this->errors[] = 'Користувача з таким логіном не існує';
            }

            if($this->checkPass($this->password) != $this->password)
            {
                $this->errors[] = 'Невірний пароль';
            }

            if(empty($this->errors))
            {
                header('Location: main.php');
            }
            else
            {
                echo '<div style="color: red">' . array_shift($this->errors) . '</div><hr>';
            }
        }
    }
}

$a = new makeEnter();
$a->makeLog($_POST['login'], $_POST['password']);
$_SESSION['user'] = $a->login;

?>

<form class="login-form" action="login.php" method="post">
    <p>
        <p>Логін</p>
        <input class="icon-user" type="text" name="login">
    </p>
    <p>
        <p>Пароль</p>
        <input type="password" name="password">
    </p>
    <p>
        <input type="submit" value="Увійти" name="log_ok">
    </p>
    <p>
        <a href="auth.php">Зареєструватись</a>
    </p>
</form>
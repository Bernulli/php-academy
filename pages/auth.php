<?php

require_once 'dbase.php';

class Auth extends dataBase
{
    private $username;
    private $email;
    private $password;
    private $password2;
    private $token;
    public $errors = [];

    public function makeUser($username, $email, $password, $password2)
    {
        if(isset($_POST['register_ok']))
        {
            if($_POST['login'] == '')
            {
                $this->errors[] = 'Введіть логін';
            }
            else
            {
                $this->username = $username;
            }

            if($_POST['email'] == '')
            {
                $this->errors[] = 'Введіть email';
            }
            else
            {
                $this->email = $email;
            }

            if($_POST['password'] == '')
            {
                $this->errors[] = 'Введіть пароль';
            }
            else
            {
                $this->password = $password;
            }

            if($password2 != $this->password)
            {
                $this->errors[] = 'Повторний пароль не співпадає';
            }
            else
            {
                $this->password2 = $password2;
            }

            if($this->uniqueUserName($this->username) == $this->username)
            {
               $this->errors[] = 'Користувач з таким логіном вже існує';
            }

            if($this->uniqueUserEmail($this->email) == $this->email)
            {
                $this->errors[] = 'Користувач з таким email вже існує';
            }

            if(empty($this->errors))
            {
                $this->token = hash('ripemd128', "$this->password");
                $this->addUser($this->username, $this->email, $this->token);
                echo '<div style="color: green">Ви успішно зареєструвались</div><hr>';
            }
            else
            {
                echo '<div style="color: red">' . array_shift($this->errors) . '</div><hr>';
            }
        }
    }
}

$a = new Auth();
$a->makeUser($_POST['login'], $_POST['email'], $_POST['password'],
            $_POST['password2']);
?>

<form class="login-form" action="auth.php" method="post">
    <p>
        <p>Логін</p>
        <input class="icon-user" type="text" name="login">
    </p>
    <p>
        <p>Email</p>
        <input class="icon-user" type="text" name="email">
    </p>
    <p>
        <p>Пароль</p>
        <input class="icon-password" type="password" name="password">
    </p>
    <p>
        <p>Підтвердити пароль</p>
        <input class="icon-password" type="password" name="password2">
    </p>
    <p>
        <input type="submit" value="Зареєструватись" name="register_ok">
    </p>
    <p>
        <a href="login.php">Увійти</a>
    </p>
</form>

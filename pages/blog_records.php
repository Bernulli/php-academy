<?php

session_start();

require_once 'dbase.php';

class blog extends dataBase
{
    private $name;
    private $textarea;
    public $datetime;


    public function getMess($textarea)
    {
        if(!empty($_POST))
        {
            $this->name = $_SESSION['user'];
            $this->textarea = $textarea;
            $this->datetime = date('Y-m-d H:i:s');
        }
    }

    public function toDataBase()
    {
        $this->addBlogRecordings($this->name, $this->datetime, $this->textarea);
    }
}
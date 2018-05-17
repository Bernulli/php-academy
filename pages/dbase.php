<?php

session_start();

class dataBase
{
    protected $db;
    private $result;
    public $count;

    public function __construct()
    {
        try
        {
            $this->connect();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function connect()
    {
        $config = require_once 'config.php';

        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];

        $this->db = new PDO($dsn, $config['username'], $config['password']);

        return $this;
    }

    public function uniqueUserName($username)
    {
        $stmt = $this->db->prepare("SELECT username FROM users WHERE username=:username");
        $stmt->execute(['username' => $username]);
        return $this->db2arrFieldName($stmt);
    }

    public function uniqueUserEmail($email)
    {
        $stmt = $this->db->prepare("SELECT email FROM users WHERE email=:email");
        $stmt->execute(['email' => $email]);
        return $this->db2arrFieldEmail($stmt);
    }

    public function checkPass($password)
    {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE password=:password");
        $stmt->execute(['password' => $password]);
        return $this->db2arrFieldPassword($stmt);
    }

    public function addUser($username, $email, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO users(username, email, password)
                                          VALUES(:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
    }

    public function addBlogRecordings($author, $datetime, $textarea)
    {
        $stmt = $this->db->prepare("INSERT INTO blog(author, datetime, txt)
                                          VALUES(:author, :datetime, :txt)");
        $stmt->execute(['author' => $author, 'datetime' => $datetime, 'txt' => $textarea]);
    }

    public function editRecord($text, $new_date, $datetime)
    {
        $query = "UPDATE blog SET txt=?, datetime=? WHERE datetime=?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$text, $new_date, $datetime]);
    }

    public function deleteRecord($txt)
    {
        $stmt = $this->db->prepare("DELETE FROM blog WHERE txt=:txt");
        $stmt->execute(['txt' => $txt]);
    }

    public function addCommentToRecord($comment_author, $comment_date, $comment_txt, $user_id, $blog_id)
    {
        $stmt = $this->db->prepare("INSERT INTO comments(comment_author, comment_date, comment_txt, user_id, blog_id)
                                          VALUES(:comment_author, :comment_date, :comment_txt, :user_id, :blog_id)");
        $stmt->execute(['comment_author' => $comment_author, 'comment_date' => $comment_date,
                        'comment_txt' => $comment_txt, 'user_id' => $user_id, 'blog_id' => $blog_id]);
    }

    public function getBlogRecordings()
    {
        //$query = "SELECT * FROM blog LEFT JOIN comments ON blog.blog_id = comments.blog_id";
        $query = "SELECT * FROM blog ORDER BY datetime DESC";
        $this->result = $this->db->query($query);
        return $this->db2arrBlogRecords($this->result);
    }

    public function getCommentRecordings()
    {
        $query = "SELECT * FROM comments";
        $this->result = $this->db->query($query);
        return $this->db2arrComments($this->result);
    }

    public function getUser()
    {
        $query = "SELECT * FROM users";
        $this->result = $this->db->query($query);
        return $this->db2arrFieldUsers($this->result);
    }

    public function db2arrFieldUsers($result)
    {
        $m = [];
        foreach($result as $row)
        {
            $m[] = $row;
        }
        return $m;
    }

    public function db2arrComments($result)
    {
//        $m = [];
//        foreach($result as $row)
//        {
//            $m[] = $row;
//        }
//        return $m;

        $m = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            $m[] = $row;
        }
        return $m;
    }

    public function db2arrBlogRecords($result)
    {
//        $m = [];
//        foreach($result as $row)
//        {
//            $m[] = $row;
//        }
//        return $m;

        $m = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            $m[] = $row;
        }
        return $m;
}

    public function db2arrFieldName($result)
    {
        $m = null;
        foreach($result as $row)
        {
            $m = $row['username'];
        }
        return $m;
    }

    public function db2arrFieldEmail($result)
    {
        $m = null;

        foreach($result as $row)
        {
            $m = $row['email'];
        }
        return $m;
    }

    public function db2arrFieldPassword($result)
    {
        $m = null;

        foreach($result as $row)
        {
            $m = $row['password'];
        }
        return $m;
    }
}

?>
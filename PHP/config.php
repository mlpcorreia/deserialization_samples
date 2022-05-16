<?php
    define('DEBUG', false);
    session_start();
    const PATH_TO_SQLITE_DB = 'users.db';
    $db_con = new PDO('sqlite:' . PATH_TO_SQLITE_DB);

    class User {
        public $username;
        public $name;
        public $email;

        public function __construct($username, $name, $email) {
            $this->username = $username;
            $this->name = $name;
            $this->email = $email;
        }

        public function __wakeup() {
            shell_exec('send_email.sh ' . $this->email);
        }
    }
?>

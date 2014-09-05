<?php

require_once "SADatabase.php";

class User {
	private $userID;
    private $email;
    private $nickname;

	public function __construct($id = 0){
        $this->userID = $id;
        // get user email and nickname from database
        if ($id != 0) {

            $conn = SADatabase::getConnection();

            $sql = 'SELECT * FROM users WHERE UserID = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_array();
                $this->email = $row['Email'];
                $this->nickname = $row['Nickname'];
            }
            else {
                $this->userID = 0;
            }

            $stmt->close();
        }
    }

    public function loggedIn() {
    	if ($this->userID > 0) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    // if not logged in, return 0
    public function getID() { return $this->userID; }

    // if not logged in, return empty string
    public function getEmail() { return $this->email; }

    // if not logged in, return empty string
    public function getNickname() { return $this->nickname; }

    // for controller
    public function signIn($email, $password) {   
        $conn = SADatabase::getConnection();

        $sql = 'SELECT * FROM users WHERE Email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_array();
            $hash = $row['Password'];
            if (password_verify($password, $hash))
            {
                $_SESSION['userID'] = $row['UserID'];

                return 'success';
            }
            else {
                return "invalid_password";
            }
        }
        else {
            return 'user_not_exist';
        }

        $stmt->close();
    }

    
    // for controller
    public static function signUp($email, $password, $nickname) {       
        $conn = SADatabase::getConnection();

        // check duplicate email
        $sql = 'SELECT * FROM users WHERE Email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows != 0) return 'user_email_exist';

        // check duplicate nickname
        $sql = 'SELECT * FROM users WHERE Nickname = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows != 0) return 'user_nickname_exist';

        // sign up
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (Email, Password, Nickname) VALUES(?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $email, $password_hashed, $nickname);
        if ($stmt->execute()) {
            $_SESSION['userID'] = $conn->insert_id;
            return 'success';
        }
        else {
            return 'fail';
        }

        $stmt->close();
    }

    // for controller
    public static function signOut() {
        unset($_SESSION['userID']);
        return 'success';
    }
}
?>
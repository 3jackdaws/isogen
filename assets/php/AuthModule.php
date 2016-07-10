<?php

/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/26/2016
 * Time: 10:20 AM
 */
class AuthModule
{
    private $_connection;
    private $_response = [];
    public function __construct()
    {
        $this->_connection = new PDO('mysql:host=localhost;dbname=isogen', 'isogen', '');
        date_default_timezone_set('America/Los_Angeles');
    }

    public function addUser($name, $username, $password){
        $statement = $this->_connection->prepare("SELECT username FROM iso_users WHERE username=:uname;");
        $statement->bindParam(':uname', $username);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(count($results) > 0){
            return $this->createResponse(1, "A user with that username already exists");

        }
        
        $pass_hash = password_hash($password, PASSWORD_BCRYPT);
        $cookie = password_hash( date("Y-m-d-h-s") . $username, PASSWORD_BCRYPT);

        $sql = "INSERT INTO iso_users (username, password, name, joindate, cookie) VALUES(:username, :password, :name, :joindate, :cookie);";
        $statement = $this->_connection->prepare($sql);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $pass_hash);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':joindate', date('Y-m-d'));
        $statement->bindParam(':cookie', $cookie);

        if(!$statement->execute()){
            return $this->createResponse(1, "Database insert error: [Prepared execute]");
        }
        else{
            $this->_response["cookie"] = $cookie;
            return $this->createResponse(0, "Created user successfully");
        }
    }

    public function login($uname, $password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $statement = $this->_connection->prepare("SELECT * FROM iso_users WHERE username=:uname;");
        $statement->bindParam(':uname', $uname);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
        if(count($results) == 0){

        }
        else if(password_verify($password, $results["password"])){
            return $this->fullLoginResponse($results["name"], $results["username"], $results["cookie"], $results["joindate"], $results["permissions"], $results["userid"]);
        }
        return $this->jsonError("No user with that password exists");

    }

    public function loginFromToken($token){
        $statement = $this->_connection->prepare("SELECT * FROM iso_users WHERE cookie=:token;");
        $statement->bindParam(':token', $token);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
        if(count($results) == 0){
            return $this->jsonError("Invalid Login Token");
        }
        return $this->fullLoginResponse($results["name"], $results["username"], $results["cookie"], $results["joindate"], $results["permissions"], $results["userid"]);


    }

    private function createResponse($errorexists, $message){
        $this->_response["message"] = $message;
        $this->_response["error"] = $errorexists;
        return json_encode($this->_response);
    }

    private function fullLoginResponse($name, $user, $token, $jdate, $permission, $id){
        $this->_response["message"] = "Login successful";
        $this->_response["error"] = 0;
        $this->_response["name"] = $name;
        $this->_response["user"] = $user;
        $this->_response["cookie"] = $token;
        $this->_response["joindate"] = $jdate;
        $this->_response["permissions"] = $permission;
        $this->_response["id"] = $id;
        return json_encode($this->_response);
    }
    private function jsonError($message){
        $this->_response["message"] = $message;
        $this->_response["error"] = 1;
        return json_encode($this->_response);
    }

    public function permLevel($token, $min){
        $statement = $this->_connection->prepare("SELECT permissions FROM iso_users WHERE cookie=:token;");
        $statement->bindParam(':token', $token);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results >= $min;
    }
}
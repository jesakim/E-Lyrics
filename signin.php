<?php
session_start();
include('script.php');



class user extends dbcon{
    static public function signin($email,$pass){
       
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([$email]);
        if($exe ->rowCount() > 0){
        $res = $exe -> fetch();
        if(password_verify($pass,$res['password'])){
            return $res;
        }else
        {
        return false;
        }   
    }
    }

    
}

if(isset($_POST['submit'])){
    if(user::signin($_POST['email'],$_POST['password'])){
        $_SESSION['user'] = user::signin($_POST['email'],$_POST['password']);
        var_dump($_SESSION['user']);
        header('location:dashboard.php');
    }else{
    $_SESSION['errormsg']="Incorrect Email Or Password";
    header('location:index.php');
    }
}
if(isset($_POST['logout'])){
    session_destroy();
    header('location:index.php');
}

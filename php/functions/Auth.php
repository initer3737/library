<?php 
// require_once("db.php");
class Auth extends Server{
    
   static function SecureInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    static function Login($user,$pass)
    {//ketika $user adalah email atau username maka?
        $Data=self::Koneksi();
        $userValidate=$Data->query("select * from login where username='$user' or email='$user'");
       if(mysqli_num_rows($userValidate) > 0){  
         //ketika ditemukan
         $result=$userValidate->fetch_assoc();
         $passVerify=password_verify($pass,$result['password']);
             if(!$passVerify){
             return false;
             }
         $_SESSION['login']=true;
         setcookie("username",$result['username'],time()+3600); //cookies will expired in 1 hours
         setcookie("password",$result['password'],time()+3600);
             header('location:shop.php');
         return true;
        }else{
          return "!user";
        }
    }

    static function Register($user,$pass,$telp)
    {$queri="select username from login where username='$user'";
            if(self::Koneksi()->query($queri)->num_rows >0){
                //ketika eror maka harus mereturn false
                //ini akan digunakkan ketika method ini mereturn false maka akan dilakukan validasi bahwa username sudah digunakkan 
                return false;
            }
            
            $passEnkrip=password_hash($pass,PASSWORD_DEFAULT);
            $queri="INSERT INTO login(username,password,telp) VALUES ('$user','$passEnkrip','$telp')";
        return self::RunQuery($queri,"register gagal error 500",header('location: index.php'));
        
    }


    static function Hash($pass)
    {
        $passEnkrip=password_hash($pass,PASSWORD_DEFAULT);
        return $passEnkrip;
    }

   static function Reset($user,$pass){
       $passEnkript=password_hash($pass,PASSWORD_DEFAULT);
        $queri="update login set password='$passEnkript' where username='$user'";
        $datas=self::RunQuery($queri,"reset gagal eror 500",header('location:index.php'));
        return $datas;
   }

    static function RunQuery($run,$ifErrMsg,$callback=null)
    { 
        if(self::Koneksi()->query($run)){
            return $callback;
        }else{
            echo $ifErrMsg;
        }
    }
}


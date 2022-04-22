<?php
class Server{
 static function Koneksi()
 {
    $host='127.0.0.1:3307';$user='root';$pass='';$dbname='web';
    return new mysqli($host,$user,$pass,$dbname);
 }
}
       

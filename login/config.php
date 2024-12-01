<?php
try{
    $pdo=new PDO("mysql:dbname=banco;host=localhost","root",""); 
}catch(PDOException $error){
    echo "Problema com BD :/...".$error->getMessage();
}
?>
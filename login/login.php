<?php
session_start();
require("config.php");
   if(isset($_POST['agencia'])&&!empty($_POST['agencia'])
    &&isset($_POST['senha'])&&!empty($_POST['senha'])
    &&isset($_POST['conta'])&&!empty($_POST['conta'])){
    //para login ja basta htmlspecial + prepare
    $agencia=htmlspecialchars($_POST['agencia']);
    $pass=htmlspecialchars($_POST['senha']);
    $conta=htmlspecialchars($_POST['conta']);

    $sql=$pdo->prepare("SELECT * FROM cadastros WHERE :conta=conta AND :agencia=agencia AND :senha=senha");
    $sql->bindValue(':conta',$conta);
    $sql->bindValue(':agencia',$agencia);
    $sql->bindValue(':senha',$pass);
    $sql->execute();

    if($sql->rowCount()>0){
        $sql=$sql->fetch();

        $_SESSION['banco']=$sql['id'];//minha session leva o id do bd como valor
        header("Location:../principal/index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="background-color: #292929;">
    <form method="post">
        <p style="color: white;">Agencia</p> 
        <input type="text" name="agencia">

        <p style="color: white;">Conta</p> 
        <input type="text" name="conta">

        <p style="color: white;">Senha</p> 
        <input type="text" name="senha">
        <br><br>

        <input type="submit" value="Enviar">
        <hr>
    </form>
    
</body>
</html>
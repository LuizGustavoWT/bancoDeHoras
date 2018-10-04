<?php
session_start();
require_once 'classes/Usuarios.php';
$usr = new Usuarios();
if(isset($_GET['login']) && !empty($_GET['login'])){
    if( isset($_POST['usr']) && !empty($_POST['usr']) &&
        isset($_POST['psw']) && !empty($_POST['psw']))
    {
        if($usr->login($_POST['usr'],$_POST['psw'])){
            $_SESSION['id'] = $usr->getId();
            header("location: index.php");
        }else{
            echo "<script>alert('Usuário ou senha incorretos')</script>";
        }

    }
}
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>Banco De Horas</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png">
    <script src="js/jquery-3.3.1.js" ></script>
    <script src="js/script.js" ></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap-reboot.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap-grid.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div class="painel_login">
        <form class="form-signin" method="post" action="?login=true">
            <div class="box">
            <img class="mb-4 img_log" src="img/logo.png" width="120" height="110">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
            </div>
            <div class="form-group">
                <label for="inputUser" class="sr-only">Usuário</label>
                <input type="text" id="inputUser" class="form-control" placeholder="Usuário" required autofocus name="usr">
            </div>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">Senha</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required name="psw">
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Lembrar
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit"> Entrar </button>
            <p class="mt-5 mb-3 text-muted">&copy; Luiz Gustavo</p>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_REQUEST['sair']) && !empty($_REQUEST['sair'])) {
    session_destroy();
    header("location: login.php");
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
    <script src="js/bootstrap.js" ></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link href="css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap-reboot.css" type="text/css" rel="stylesheet"/>
    <link href="css/bootstrap-grid.css" type="text/css" rel="stylesheet"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<header>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                        <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="relatorios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Relatórios
                    </a>
                    <div class="dropdown-menu" aria-labelledby="relatorios">
                        <a class="dropdown-item" href="saldoFuncionarios_Rel.php">
                            Saldos por funcionario
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item disabled" href="#">
                            Saldo por centro de custo
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="historico.php">
                            Histórico De Lançamento
                        </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="operacoes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Operações
                    </a>
                    <div class="dropdown-menu" aria-labelledby="operacoes">
                        <a class="dropdown-item" href="cadastrar.php">
                            Cadastrar colaborador
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="editarColaborador.php    ">
                            Atualizar dados do colaborador
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="listar.php">
                            Listar colaboradores
                        </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?sair=1">Sair</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
</header>
<div class="container">


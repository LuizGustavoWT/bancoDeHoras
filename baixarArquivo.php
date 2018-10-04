<?php
session_start();
if (isset($_SESSION['id']) && !empty($_SESSION['id'])){

    if(isset($_GET['arq']) && !empty($_GET['arq'])){
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="'.$_GET['arq'].'"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize("arquivos/".$_GET['arq']));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        flush();
        // Envia o arquivo para o cliente
        readfile('arquivos/'.$_GET['arq']);
        header("Location: saldoFuncionarios_Rel.php");
        exit;
    }else{
        header("Location: saldoFuncionarios_Rel.php");
    }
}else{
    header("Location: index.php");
}
?>
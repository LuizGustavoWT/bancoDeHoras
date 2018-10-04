<?php 
    require_once 'classes/Relatorios.php';
    require_once 'classes/LancarHoras.php';
    $rel = new Relatorios();
    $hor = new LancarHoras();
    $ret = $hor->listarLancamento(1616);
    foreach ($ret as $r){
        print_r($r);
        echo "</br>";
    }
?>
<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    require_once 'classes/LancarHoras.php';
    require 'header.php';
    $hor = new LancarHoras();
    if( (isset($_GET['cpd']) && !empty($_GET['cpd']))&&
        (isset($_GET['id_historico']) && !empty($_GET['id_historico']))&&
        (isset($_GET['qtd_horas']) && !empty($_GET['qtd_horas'])) &&
        (isset($_GET['porcentagem']) && !empty($_GET['porcentagem'])))
    {
        if($hor->corrigirLancamento($_GET['qtd_horas'],$_GET['id_historico'],$_GET['porcentagem'],$_GET['cpd'])){
            header("Location: corrigirLancamento.php?cpd=".$_GET['cpd']);
        }else{
            echo "<script>alert('Erro ao corrigir!!')</script>";
            header("Location: corrigirLancamento.php?cpd=".$_GET['cpd']);
        }
    }
    else if(isset($_GET['cpd']) && !empty($_GET['cpd'])) {
        $ret = $hor->listarLancamento($_GET['cpd']);
        ?>

        <div class="box2">
            <div class="tabela2" >
            <div class="row">
                <div class="col-md-3"><label>Descrição</label></div>
                <div class="col-md-2"><label>Horas</label></div>
                <div class="col-md-3"><label>Dia</label></div>
                <div class="col-md-3"><label>Ação</label></div>
            </div>
            <?php
            foreach ($ret as $r){
                ?>
                <div class="row">
                    <div class="col-md-3"><label><?php echo $r['tipo_de_hora'];?></label></div>
                    <div class="col-md-2"><label><?php echo $r['qtd_horas'];?></label></div>
                    <div class="col-md-3"><label><?php echo date("d/m/Y",strtotime($r['data_mov']));  ?></label></div>
                    <div class="col-md-3">
                        <a class="btn btn-danger" href="corrigirLancamento.php?cpd=<?php echo $_GET['cpd'];?>&porcentagem=<?php echo $r['porcentagem']?>&id_historico=<?php echo $r['id_historico'];?>&qtd_horas=<?php echo $r['qtd_horas'];?>">
                            <label>Corrigir</label>
                        </a>
                    </div>
                </div>
                <hr>
                <?php
            }
            ?>
            </div>
        </div>

        <?php
    }else{
        ?>
        <div class="box2">
            <div class="form_fun">
                <form action="" method="get">
                    <div class="form-group">
                        <input class="form-control" placeholder="CPD" name="cpd">
                    </div>
                    <div class="form-group">
                        <a class="btn btn-dark">
                            <i style="color: #fff;" class="fas fa-search"></i>
                            <span>Corrigirr</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
        ?>


    <?php
    require 'footer.php';
}else{
    header("Location: index.php");
}

?>
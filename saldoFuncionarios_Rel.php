<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    require_once 'header.php';

    require_once 'classes/Relatorios.php';
    $rela = new Relatorios();
        if( (isset($_POST['campo']) && !empty($_POST['campo']))&&
        (isset($_POST['ordem']) && !empty($_POST['ordem']))){
            if(isset($_POST['excel']) && !empty($_POST['excel'])){
                $ret = $rela->saldoPorFuncionarioDecCres($_POST['campo'],$_POST['ordem']);
                $retorna = $rela->gerarExcel($ret);
                header("Location: baixarArquivo.php?arq=".$retorna);


            }
            else{
                $ret = $rela->saldoPorFuncionarioDecCres($_POST['campo'],$_POST['ordem']);
            }
        }
        else{
            $ret = $rela->saldoPorFucionario();
        }
    ?>
    <div class="box2">extsofts_global_corporation_user
        <form method="post">
            <div class="row">
                <div class="form-group col-auto">
                    <select class="form-control" name="campo">
                        <option value="0" <?php echo (isset($_POST['campo']))?($_POST['campo'] == "0")?'selected':'':''; ?>>Campo</option>
                        <option value="nome"
                            <?php echo (isset($_POST['campo']))? ($_POST['campo'] == "nome")?'selected':'':''; ?>>Nome</option>
                        <option value="saldo"
                            <?php echo (isset($_POST['campo']))? ($_POST['campo'] == "saldo")?'selected':'':''; ?>>Saldo</option>
                        <option value="cpd"
                            <?php echo (isset($_POST['campo']))?($_POST['campo'] == "cpd")?'selected':'':''; ?>>cpd</option>
                    </select>
                </div>
                <div class="form-group col-auto">
                    <select class="form-control" name="ordem">
                        <option value="0"
                            <?php echo (isset($_POST['ordem']))?($_POST['ordem'] == "0")?'selected':'':''; ?>>Ordem</option>
                        <option value="asc"
                            <?php echo (isset($_POST['ordem']))?($_POST['ordem'] == "asc")?'selected':'':'';?>>Crescente</option>
                        <option value="desc"
                            <?php echo (isset($_POST['ordem']))?($_POST['ordem'] == "desc")?'selected':'':'';?>>Decrescente</option>
                    </select>
                </div>
                <div class="form-group col-auto">
                    <button type="submit" class="btn btn-dark">
                        <i style="color: #fff" class="fas fa-filter"></i>
                        <span>Filtrar</span>
                    </button>
                </div>
                <div class="form-group col-auto">
                    <button type="submit" class="btn btn-dark" name="excel" value="ger">
                        <i style="color: #fff" class="far fa-file-excel"></i>
                        <span>Gerar Em Excel</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="tabela">
            <div class="row">
                <div class="col col-lg-1">CPD</div>
                <div class="col col-lg-8">Nome</div>
                <div class="col">Saldo</div>
            </div>

        <?php

        foreach ($ret as $r){
            ?>
            <div class="row">
                <div class="col col-lg-1"><?php echo $r['cpd'];?></div>
                <div class="col col-lg-8"><?php echo $r['nome'];?></div>
                <div class="col"><?php echo $r['saldo'];?></div>
            </div>
            <?php
        }

        ?>
        </div>
    </div>
    <?php
    require 'footer.php';
}else{
    header("location: index.php");
}
?>
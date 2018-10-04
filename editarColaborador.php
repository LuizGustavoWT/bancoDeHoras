<?php
session_start();
require_once 'classes/Funcionario.php';
$col =new Funcionario();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    require 'header.php';
    if(!isset($_GET['cpd'])) {
        ?>
        <div class="box2">
            <div class="form_fun">
                <form action="" method="get">
                    <div class="form-group">
                        <input class="form-control" placeholder="CPD" name="cpd">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-dark">
                            <i style="color: #fff;" class="fas fa-search"></i>
                            <span>Pesquisar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php
    }else{
        $ret = $col->listagemEdicao($_GET['cpd']);
        if( (isset($_GET['cdc']) && !empty($_GET['cdc'])) &&
            (isset($_GET['nome']) && !empty($_GET['nome'])) &&
            (isset($_GET['status']))){
            if($col->atualizarFuncionario($_GET['cpd'],$_GET['nome'],$_GET['status'],$_GET['cdc'])){
                header("location: editarColaborador.php?cpd=".$_GET['cpd']);
            }else{
                echo "<script>alert('Falha Ao Atualizar!!')</script>";
            }
        }
        ?>
        <div class="box2">
            <div class="form_fun">
                <form action="" method="get">

                    <input type="hidden" class="form-control" value="<?php echo $ret['cpd']?>" name="cpd">
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" value="<?php echo $ret['nome'] ?>" name="nome"/>
                    </div>
                    <div class="form-group">
                        <label>Centro De Custo</label>
                        <select class="form-control" name="cdc" autofocus>
                            <?php
                                $lista = $col->listarCentroDeCusto();

                                foreach ($lista as $l){
                                    ?>
                                    <option value="<?php echo $l['id']?>"
                                    <?php
                                    echo ($ret['id_centro_de_custo'] == $l['id'])? 'selected':'';  ?>><?php echo $l['cod_cc']." - ".$l['descricao']; ?></option>
                                    <?php
                                }

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required class="form-control">
                            <option value="1" <?php echo ($ret['status'] == 1)?'selected':'';?>>Ativo</option>
                            <option value="0" <?php echo ($ret['status'] != 1)?'selected':'';?>>Desligado/Afastado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-dark">
                            <i style="color: #fff;" class="fas fa-sync"></i>
                            <span>Atualizar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    require 'footer.php';
}
else{
    header("location: index.php");
}
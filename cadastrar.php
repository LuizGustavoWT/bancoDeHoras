<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    require 'header.php';
    require_once 'classes/Funcionario.php';
    $col = new Funcionario();
    if(isset($_REQUEST['cad']) && !empty($_REQUEST['cad'])){
        if( (isset($_POST['nome']) && !empty($_POST['nome'])) &&
            (isset($_POST['cpd']) && !empty($_POST['cpd'])) &&
            (isset($_POST['cdc']) && !empty($_POST['cdc']))){

            if ($col->cadastrarNovoFuncionario($_POST['nome'],$_POST['cpd'],$_POST['cdc'])){
                echo "<script>alert('Funcionário Cadastrado Com Sucesso!!!');</script>";
            }else{
                echo "<script>alert('Erro Ao Cadastrar!!!');</script>";
            }

        }
    }
    ?>
    <div class="box2">
        <div class="form_fun">
            <form method="post" action="?cad=true">
                <div class="form-group">
                    <label>CPD</label>
                    <input class="form-control" type="text" name="cpd" placeholder="CPD" autofocus  />
                </div>
                <div class="form-group">
                    <label>Nome</label>
                    <input class="form-control" type="text" name="nome" placeholder="Nome"/>
                </div>
                <div class="form-group">
                    <label>Centro De Custo</label>
                    <select class="form-control" name="cdc">
                        <?php
                        $ret = $col->listarCentroDeCusto();
                        foreach ($ret as $r){
                            ?>
                            <option value="<?php echo $r['id']?>"><?php echo $r['cod_cc']." - ".$r['descricao']?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-dark">
                        <i style="color: #fff" class="far fa-save"></i>
                        <span>Cadastrar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php
    require 'footer.php';
}
?>
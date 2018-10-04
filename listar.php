<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    require_once 'classes/Funcionario.php';
    $col = new Funcionario();
    require 'header.php';
    ?>
    <div class="box2">
        <div class="tabela">
            <div class="row">
                <div class="col col-lg-1"><label><b>CPD</b></label></div>
                <div class="col col-lg-6"><label><b>Nome</b></label></div>
                <div class="col col-lg-2"><label><b>Saldo</b></label></div>
                <div class="col col-lg-3"><label><b>Operações</b></label></div>
            </div>
            <?php
            $ret = $col->listarFuncionarios();
            foreach ($ret as $r){
                ?>
                <div class="row">
                    <div class="col col-lg-1">
                        <label>
                            <?php echo $r['cpd'];?>
                        </label>
                    </div>
                    <div class="col col-lg-6">
                        <label>
                            <?php echo $r['nome'];?>
                        </label>
                    </div>
                    <div class="col col-lg-2">
                        <label>
                            <?php echo $r['saldo'];?>
                        </label>
                    </div>
                    <div class="col col-lg-3">
                        <label>
                            <label>
                                <a class="btn btn-danger" href="lancamentos.php?id_usr=<?php echo $r['cpd'];?>">
                                    Lançar
                                </a>

                                <a class="btn btn-light" href="editarColaborador.php?cpd=<?php echo $r['cpd'];?>">

                                    Editar Dados

                                </a>
                            </label>
                        </label>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <?php
require 'footer.php';
}
else{
    header("location: index.php");
}

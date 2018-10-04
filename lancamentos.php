<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    require_once 'classes/Funcionario.php';
    $col = new Funcionario();
    require_once 'classes/LancarHoras.php';
    $hor = new LancarHoras();
    require 'header.php';
    if(isset($_REQUEST['id_usr'])&& !empty($_REQUEST['id_usr'])) {
        $ret = $col->consultarHoras($_GET['id_usr']);
        if( (isset($_GET['qtde']) && !empty($_GET['qtde'])) &&
            (isset($_GET['tipo']) && !empty($_GET['tipo']))){

            if($hor->lancarHoras($_GET['qtde'], $ret['id'],$_SESSION['id'],$_GET['tipo'],$_GET['id_usr']))
            {
                echo "<script>alert('Horas Lançadas')</script>";
                header("Location: lancamentos.php?id_usr=".$_GET['id_usr']);
            }
            else
            {
                echo "<script>alert('Não Foi Possivel Lançar As Horas')</script>";
            }

        }
        if ($ret['status'] == 1) {
            ?>


            <div class="box2">
                <div class="form_fun">
                    <form action="?" method="get">
                        <div class="row">
                            <label class="col-auto">Nome:</label>
                            <output class="col-auto">
                                <?php echo $ret['nome']; ?>
                            </output>
                        </div>
                        <div class="row">
                            <label class="col-auto">CPD</label>
                            <output class="col-auto">
                                <?php echo $ret['cpd']; ?>
                            </output>
                        </div>
                        <div class="row">
                            <label class="col-auto">Saldo</label>
                            <output class="col-auto"><?php echo $ret['saldo']; ?></output>
                            <input type="hidden" value="<?php echo $ret['cpd']; ?>" name="id_usr">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="tipo">
                                <?php
                                $volta = $hor->listarHoras();

                                foreach ($volta as $v) {
                                    ?>
                                    <option value="<?php echo $v['id']; ?>">
                                        <?php echo $v['descricao']; ?>
                                    </option>
                                    <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Horas: </label>
                            <input class="form-control" type="time" name="qtde">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-dark" type="submit" id="enviar">
                                <i style="color: #fff;" class="fas fa-paper-plane"></i>
                                <span aria-labelledby="enviar">Lançar</span>
                            </button>
                            <a class="btn btn-danger" href="corrigirLancamento.php?cpd=<?php echo $_GET['id_usr'];?>">
                                <i style="color: #fff;" class="fas fa-eraser"></i>
                                <span aria-labelledby="enviar">Corrigir</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
        else{
            header("location: listar.php");
        }
    }

    require 'footer.php';
}
else{
    header("location: index.php");
}
?>

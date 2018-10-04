<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    require 'header.php';

    ?>
    <div class="container">
        <div class="box2">
            <div class="apresentar">
                <h4>Sistema de banco de horas</h4>
                <h5>Desenvolvido por - Luiz Gustavo</h5>
                <label>Dúvidas ou Sugestões - <a href="mailto:gustavoweberthums@hotmail.com">Mande e-mail</a></label>
            </div>
        </div>
    </div>

    <?php
    require 'footer.php';
}
else{
    header("location: login.php");
}
?>

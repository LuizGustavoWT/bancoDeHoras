<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    require 'header.php';
    ?>
    <div class="box2">
    <h1 style="color:#fff;">Em Desenvolvimento...</h1>
    </div>
    <?php
    require 'footer.php';
}
else{
    header("Location: index.php");
}

?>
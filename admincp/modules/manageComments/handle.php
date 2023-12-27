<?php
    include("../../config/config.php"); 
    $sql_xoa = "DELETE FROM tb_comment WHERE id=".$_GET["id"];
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../../index.php?comments');  
?>
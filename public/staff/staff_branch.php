<?php
    if(isset($_POST['edit'])==true){
        $disp_id=$_POST['id'];
        header('Location:staff_edit.php?id='.$disp_id);
        exit;
    }

    if(isset($_POST['delete'])==true){
        $disp_id=$_POST['id'];
        header('Location:staff_delete_done.php?id='.$disp_id);
        exit;
    }
?>
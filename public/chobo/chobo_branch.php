<?php

if ($_POST['edit'] == true) {
    $disp_id = $_POST['id'];
    header('Location:chobo_edit.php?id=' . $disp_id);
    exit;
}
if ($_POST['delete'] == true) {
    $disp_id = $_POST['id'];
    header('Location:chobo_delete_done.php?id=' . $disp_id);
    exit;
}

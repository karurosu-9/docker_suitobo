<?php

if($_POST['add']){
header('Location:busho_add.php');
exit;
}

if($_POST['delete']){
if(isset($_POST['id'])==false){
header('Location:busho_ng.php');
exit;
}
$id=$_POST['id'];
header('Location:busho_delete.php?id='.$id);
exit;
}

?>
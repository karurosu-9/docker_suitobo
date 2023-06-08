<?php

if ($_POST['add']) {
    header('Location:kanjo_add.php');
    exit;
}

if ($_POST['delete']) {
    if (isset($_POST['id']) == false) {
        header('Location:../kanjo_kamoku/kanjo_ng.php');
        exit;
    }
    $id = $_POST['id'];
    header('Location:kanjo_delete.php?id=' . $id);
    exit;
}

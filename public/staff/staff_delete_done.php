<?php
session_start();
session_regenerate_id();

try {

    $disp_id=$_GET['id'];

    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);

    $sql = 'DELETE FROM staff_list WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $disp_id;
    $stmt->execute($data);

    $dbh = null;

} catch (Exception $e) {
    $e->getMessage();
    echo "ただいま障害によりご迷惑をおかけしております。";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>出納帳---削除画面</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php

    if (isset($_SESSION['login']) == false) {
        echo "ログインされていません。<br>";
        echo "<br>";
        echo '<a href="../staff_login/staff_login.php">ログイン画面へ</a>';
        exit;
    }
    ?>

    <script>
        alert("削除しました。");
        location.href = "staff_list.php";
    </script>
</body>

</html>
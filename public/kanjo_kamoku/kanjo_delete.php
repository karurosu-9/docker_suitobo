<?php
session_start();
session_regenerate_id();
try {
    $disp_id = $_GET['id'];
    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);

    $sql = 'SELECT * FROM kanjo_list WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $disp_id;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $rec['name'];

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
<style>
    .body {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        text-align: left;
        width: 450px;
    }

    table {
        border: black solid 2px;
        border-collapse: collapse;
        white-space: nowrap;
    }

    th {
        border: black solid 2px;
        background-color: #a9a9a9;
    }

    td {
        border: black solid 2px;
    }

    .button {
        margin-left: 70px;
    }
</style>

<body>
    <div class="body">
        <?php

        require "../menu/menu.php";

        if (isset($_SESSION['login']) == false) {
            echo "ログインされていません。<br>";
            echo "<br>";
            echo '<a href="../staff_login/staff_login.php">ログイン画面へ</a>';
            exit;
        } else {
            echo "【";
            echo $_SESSION['staff_name'];
            echo "】";
            echo "さん　ログイン中";
            echo "<br>";
        }
        ?>

        <br>
        勘定科目の削除<br>
        <br>
        <br>
        <script>
            function delete_check() {
                var msg = confirm('削除してもよろしいですか？');
                return msg;
            }
        </script>
        <form action="kanjo_delete_done.php" method="post" onclick="return delete_check();">
            <table cellpadding="6">
                <tr>
                    <th>削除する項目</th>
                </tr>
                <tr>
                    <td><?php echo $name; ?></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="id" value="<?php echo $rec['id']; ?>">
            <div class="button">
                <input type="submit" value="削除">
            </div>
        </form>
        <br>
        <br>
        <a href="kanjo_list.php">リストへ戻る</a><br>
    </div>
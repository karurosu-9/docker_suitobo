<?php
session_start();
session_regenerate_id();

try {
    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM busho_list WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;
} catch (Exception $e) {
    $e->getMessage();
    echo "ただいま障害によりご迷惑をおかけしております。";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>出納帳---一覧画面</title>
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
        text-align: center;
        background-color: #a9a9a9;

    }

    td {
        border: black solid 2px;
        text-align: center;
    }

    .button {
        margin-left: 50px;
    }

    .radio {
        display: inline-block;
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
        部署一覧<br>
        <br>
        <form action="busho_branch.php" method="post">
            <table cellpadding="6">
                <tr>
                    <th></th>
                    <th>部署項目</th>
                </tr>
                <?php while (true) { ?>
                    <?php $rec = $stmt->fetch(PDO::FETCH_ASSOC); ?>
                    <?php if ($rec == false) : ?>
                        <?php break; ?>
                    <?php endif ?>
                    <tr>
                        <td>
                            <?php
                            echo '<input type="radio" name="id" value="' . $rec['id'] . '">';
                            ?>
                        </td>
                        <td><?php echo $rec['name']; ?></td>
                    </tr>
                <?php }; ?>
            </table>
            <br>
            <br>
            <div class="button">
                <input type="submit" name="add" value="追加">
                <input type="submit" name="delete" value="削除">
            </div>
        </form>
    </div>
</body>

</html>
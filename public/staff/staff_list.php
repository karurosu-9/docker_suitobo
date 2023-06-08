<?php
session_start();
session_regenerate_id();

try {
    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM staff_list WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $e->getMessage();
    echo 'ただいま障害によりご迷惑をおかけしております。';
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

    span {
        color: red;
        font-weight: bold;
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
        社員一覧<br>
        <br>
        <?php if($_SESSION['staff_admin']==0):?>
            <button onclick="location.href='staff_add.php'">社員登録</button><br>
        <?php endif?>
        <br>
        <br>
        <div class="body">
            <table cellpadding="10">
                <tr>
                    <th colspan="4">社員リスト</th>
                </tr>
                <tr>
                    <th>社員番号</th>
                    <th>管理区分</th>
                    <th>部署</th>
                    <th>名前</th>
                </tr>
                <?php foreach ($rec as $val) : ?>
                    <tr>
                        <td><?php echo $val['id']; ?></a></td>
                        <td>
                            <?php
                            if ($val['admin'] == 0) {
                                echo "管理者";
                            } else
                                  if ($val['admin'] == 1) {
                                echo "経理";
                            } else {
                                echo "社員";
                            }

                            ?>
                        </td>
                        <td><?php echo $val['busho']; ?></td>
                        <td><a href="staff_disp.php?id=<?php echo $val['id'];?>"><?php echo $val['name']; ?></a></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
        <br>
        <br>
    </div>
</body>

</html>
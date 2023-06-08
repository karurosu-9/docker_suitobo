<?php
session_start();
session_regenerate_id();

try {

    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM suitobo_list WHERE 1 ORDER BY date';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    if (isset($_POST['month']) == true) {
        $month = $_POST['month'];
        $sql = 'SELECT * FROM suitobo_list WHERE date like ? ORDER BY date';
        $stmt = $dbh->prepare($sql);
        $data[] = '%' . $month . '%';
        $stmt->execute($data);
    }

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
        width: 550px;
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

    .button {
        margin-left: 160px;
    }

    .button2 {
        margin-left: 20px;
    }


    @media print {
        .page {
            width: 172mm;
            height: 251mm;
            margin-top: 190px;
            margin-left: 35px;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .no_print {
            display: none;
        }

    }
</style>

<body>
    <div class="body">
        <div class="no_print">
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
                echo '<input class="button" type="button" onclick="window.print();" value="印刷"><br>';
                echo "<br>";
            }

            ?>

            <br>
            帳簿一覧<br>
            <br>
            <button onclick="location.href='chobo_add.php'">帳簿登録</button><br>
            <br>
            表示したい月を選択してください。<br>
            <?php $date = date('Y-m'); ?>
            <form action="chobo_list.php" method="post">
                <input type="month" name="month" min="2022-01" max="<?php echo $date; ?>" value="<?php echo $date; ?>">
                <input type="submit" value="月別表示">
                <input class="button2" type="button" value="一覧表示" onclick="location.href='chobo_list.php'">
            </form>
        </div>
        <section class="page">
            <table cellpadding="6">
                <tr>
                    <th colspan="6">出納簿</th>
                </tr>
                <tr>
                    <th>日付</th>
                    <th>勘定科目</th>
                    <th>摘要</th>
                    <th>入金</th>
                    <th>出金</th>
                    <th>現金残高</th>
                </tr>

                <?php while (true) { ?>
                    <?php $rec = $stmt->fetch(PDO::FETCH_ASSOC); ?>
                    <?php if ($rec == false) : ?>
                        <?php break; ?>
                    <?php endif ?>
                    <tr>
                        <td><a href="chobo_disp.php?id=<?php echo $rec['id'] ?>"><?php echo $rec['date']; ?></a></td>
                        <td><?php echo $rec['kanjo']; ?></td>
                        <td><?php echo $rec['tekiyo']; ?></td>
                        <td>
                            <?php
                            if ($rec['nyukin'] >= 1) {
                                echo $rec['nyukin'] . "円";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($rec['syukkin'] >= 1) {
                                echo $rec['syukkin'] . "円";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($rec['total_price'] < 0) {
                                echo '<span>' . $rec['total_price'] . '円</span>';
                            } else {
                                echo $rec['total_price'] . "円";
                            }
                            ?>
                        </td>
                    </tr>
                <?php }; ?>
            </table>
        </section>
        <div class="no_print">
            <br>
            <br>
        </div>
    </div>
</body>

</html>
<?php
session_start();
session_regenerate_id();

$date = $_POST['date'];
$kanjo = $_POST['kanjo'];
$tekiyo = htmlspecialchars($_POST['tekiyo'], ENT_QUOTES, "UTF-8");
$price = $_POST['price'];

if ($price == 'nyukin') {
    $amount = htmlspecialchars($_POST["amount"], ENT_QUOTES, "UTF-8");
} else {
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, "UTF-8");
}

$amount_mb = mb_convert_kana($amount, "a");


$okflag = true;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>出納帳---登録画面</title>
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
    }

    th {
        border: black solid 2px;
        background-color: #a9a9a9;
    }

    td {
        border: black solid 2px;
        text-align: center;
        width: 200px;
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
        <br>
        <br>
        <table cellpadding="6">
            <tr>
                <th>日付</th>
                <td><?php echo $date; ?></td>
            </tr>
            <tr>
                <th>勘定科目 </th>
                <td><?php echo $kanjo; ?></td>
            </tr>
            <tr>
                <th>摘要</th>
                <td>
                    <?php
                    if (empty($tekiyo)) {

                        echo "<span>※内容を入力してください。</span><br>";
                        $okflag = false;
                    } else {

                        echo $tekiyo;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php
                    if (empty($price)) {
                        echo '<span>※入金<br> or<br> ※出金<br></span>';
                        $okflag = false;
                    } else
                        if ($price == 'nyukin') {
                        echo "入金";
                    } else {
                        echo "出金";
                    }

                    ?>
                </th>
                <td>
                    <?php
                    if (empty($amount_mb)) {
                        echo "<span>※金額を入力してください。</span>";
                        $okflag = false;
                    } else {
                        echo $amount_mb . "円";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <?php
        if ($okflag == true) {
            $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
            $user = "root";
            $password = "root";
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $total_price = 0;

            $sql = 'SELECT COUNT(*) FROM suitobo_list';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();


            foreach ($stmt as $row) {
                $rec = $row[0];
            }

            if ($rec >= 1) {
                $sql = 'SELECT total_price FROM suitobo_list WHERE id= (SELECT MAX(id) FROM suitobo_list)';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                $total_price = (int)$rec['total_price'];
            } else {
                $total_price = 0;
            }

            if ($price == 'nyukin') {
                $sql = 'INSERT INTO suitobo_list(date,kanjo,tekiyo,nyukin,syukkin,total_price)
                VALUES(?,?,?,?,?,?)';
                $stmt = $dbh->prepare($sql);
                $data[] = $date;
                $data[] = $kanjo;
                $data[] = $tekiyo;
                $data[] = (int)$amount_mb;
                $data[] = 0;
                (int)$total_price = (int)$total_price + (int)$amount_mb;
                $data[] = $total_price;
                $stmt->execute($data);

                $dbh = null;
            }

            if ($price == 'syukkin') {
                $sql = 'INSERT INTO suitobo_list(date, kanjo,tekiyo,nyukin,syukkin,total_price)
                VALUES(?,?,?,?,?,?)';
                $stmt = $dbh->prepare($sql);
                $data[] = $date;
                $data[] = $kanjo;
                $data[] = $tekiyo;
                $data[] = 0;
                $data[] = (int)$amount_mb;
                (int)$total_price = (int)$total_price - (int)$amount_mb;
                $data[] = $total_price;
                $stmt->execute($data);

                $dbh = null;
            }
        } else {
            echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
            exit;
        }
        ?>
        <script>
            alert("登録しました。");
            location.href = "chobo_list.php";
        </script>
    </div>
</body>

</html>
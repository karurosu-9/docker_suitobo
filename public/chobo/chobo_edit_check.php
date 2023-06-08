<?php
session_start();
session_regenerate_id();

try {
    $disp_id = $_POST['id'];
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
} catch (Exception $e) {
    $e->getMessage();
    echo "ただいま障害によりご迷惑をおかけしております。";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>product</title>
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
                    } else 
                        if (preg_match('/[0-9]+$/', $amount_mb) == 0) {
                        echo "<span>※正しい数字を入力してくだい。</span>";
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
            try {
                $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
                $user = "root";
                $password = "root";
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = 'SELECT * FROM suitobo_list WHERE id=?';
                $stmt = $dbh->prepare($sql);
                $data[] = $disp_id;
                $stmt->execute($data);

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($price == "nyukin") {
                    if ($rec['nyukin'] == true) {
                        $amount_db = $rec['nyukin'];
                        $amount_db_up = $amount_mb - $amount_db;
                    } else {
                        $amount_db = $rec['syukkin'];
                        $amount_db_up = $amount_mb + $amount_db;
                    }
                } else {
                    if ($rec['syukkin'] == true) {
                        $amount_db = $rec['syukkin'];
                        $amount_db_up = $amount_mb - $amount_db;
                    } else {
                        $amount_db = $rec['nyukin'];
                        $amount_db_up = $amount_mb + $amount_db;
                    }
                }


                if ($price == 'nyukin') {
                    $sql = 'UPDATE suitobo_list SET date=?,kanjo=?,tekiyo=?,nyukin=?,syukkin=? WHERE id=?';
                    $stmt = $dbh->prepare($sql);
                    $data2[] = $date;
                    $data2[] = $kanjo;
                    $data2[] = $tekiyo;
                    $data2[] = (int)$amount_mb;
                    $data2[] = 0;
                    $data2[] = $disp_id;
                    $stmt->execute($data2);


                    $sql = 'UPDATE suitobo_list SET total_price = total_price + ? WHERE id >= ?';
                    $stmt = $dbh->prepare($sql);
                    $data2 = array();
                    $data2[] = $amount_db_up;
                    $data2[] = $disp_id;
                    $stmt->execute($data2);

                    $dbh = null;
                }

                if ($price == 'syukkin') {
                    $sql = 'UPDATE suitobo_list SET date=?,kanjo=?,tekiyo=?,nyukin=?,syukkin=? WHERE id=?';
                    $stmt = $dbh->prepare($sql);
                    $data2[] = $date;
                    $data2[] = $kanjo;
                    $data2[] = $tekiyo;
                    $data2[] = 0;
                    $data2[] = $amount_mb;
                    $data2[] = $disp_id;
                    $stmt->execute($data2);


                    $sql = 'UPDATE suitobo_list SET total_price=total_price-? WHERE id>=?';
                    $stmt = $dbh->prepare($sql);
                    $data2 = array();
                    $data2[] = $amount_db_up;
                    $data2[] = $disp_id;
                    $stmt->execute($data2);

                    $dbh = null;
                }
            } catch (Exception $e) {
                $e->getMessage();
                echo "ただいま障害によりご迷惑をおかけしております。";
            }
        } else {
            echo '<a href = "' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
            exit;
        }
        ?>

        <script>
            alert("更新しました。");
            location.href = "chobo_list.php";
        </script>
    </div>
</body>

</html>
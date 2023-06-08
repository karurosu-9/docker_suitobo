<?php
session_start();
session_regenerate_id();

try {
    $disp_id = $_GET['id'];
    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);

    $sql = 'SELECT * FROM suitobo_list WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $disp_id;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $disp_id = $rec['id'];
    $date_db = $rec['date'];
    $kanjo_db = $rec['kanjo'];
    $tekiyo = $rec['tekiyo'];




    if ($rec['nyukin'] != 0) {
        $price = $rec['nyukin'];
    } else {
        $price = $rec['syukkin'];
    }

    $sql = 'SELECT * FROM kanjo_list WHERE 1 ';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>出納帳---編集画面</title>
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
    }

    .button {
        margin-left: 295px;
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
        取引の編集<br>
        <br>
        <br>
        <script>
            function update_check() {
                var msg = confirm("この内容で修正してよろしいですか？");
                return msg;
            }
        </script>
        <form action="chobo_edit_check.php" method="post" onsubmit="return update_check();">
            <table cellpadding="6">
                <input type="hidden" name="id" value="<?php echo $disp_id; ?>">
                <tr>
                    <th>日付</th>
                    <td>
                        <?php $date = date('Y-m-d'); ?>
                        <input type="date" name='date' min='2020-04-01' max="<?php echo $date; ?>" value="<?php echo $date_db; ?>">
                    </td>
                </tr>
                <tr>
                    <th>勘定科目 </th>
                    <td><select name="kanjo">
                            <?php
                            foreach ($row as $val) {
                                if ($kanjo_db == $val['name']) {
                                    echo '<option value="' . $val['name'] . '" selected>' . $val['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $val['name'] . '">' . $val['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>摘要</th>
                    <td><input type="text" name="tekiyo" style="width: 200px" value="<?php echo $tekiyo; ?>"></td>
                </tr>
                <tr>
                    <th>
                        <label><input type="radio" name="price" value="nyukin" checked>入金</label><br>
                        <label><input type="radio" name="price" value="syukkin">出金</label>
                    </th>
                    <td><input type="text" name="amount" style="width: 200px" value="<?php echo $price; ?>"> 円</td>
                </tr>
            </table>
            <br>
            <div class="button">
                <input type="submit" value="修正">
            </div>
        </form>
        <br>
        <br>
        <a href="chobo_list.php">リストへ戻る</a><br>
    </div>

</body>

</html>
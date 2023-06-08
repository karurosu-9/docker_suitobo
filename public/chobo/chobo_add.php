<?php
session_start();
session_regenerate_id();

try {
    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM kanjo_list WHERE 1';
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
        取引の登録<br>
        <br>
        <br>
        <script>
            function insert_button() {
                var msg = confirm("この情報を登録してよろしいですか？");
                return msg;
            }
        </script>
        <form action="chobo_add_check.php" method="post" onsubmit="insert_button();">
            <table cellpadding="6">
                <tr>
                    <th>日付</th>
                    <td>
                        <?php $date = date('Y-m-d'); ?>
                        <input type="date" name='date' min='2020-04-01' max="<?php echo $date; ?>" value="<?php echo $date; ?>">
                    </td>
                </tr>
                <tr>
                    <th>勘定科目 </th>
                    <td><select name="kanjo">
                            <?php
                            foreach ($rec as $val) {
                                echo '<option value="' . $val['name'] . '">' . $val['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>摘要</th>
                    <td><input type="text" name="tekiyo" style="width: 200px"></td>
                </tr>
                <tr>
                    <th>
                        <label><input type="radio" name="price" value="nyukin" checked>入金</label><br>
                        <label><input type="radio" name="price" value="syukkin">出金</label>
                    </th>
                    <td><input type="text" name="amount" style="width: 200px"> 円</td>
                </tr>

            </table>
            <br>
            <div class="button">
                <input type="submit" value="登録">
            </div>
        </form>
        <br>
        <br>
        <a href="chobo_list.php">リストへ戻る</a><br>
    </div>

</body>

</html>
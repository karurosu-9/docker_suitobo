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

    $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dbh = null;
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
        社員登録<br>
        <br>
        <br>
        <script>
            function add_check(){
                var msg =confirm("この情報を登録しますか？");
                return msg;
            }
        </script>
        <form action="staff_add_check.php" method="post" onsubmit="return add_check();">
            <table cellpadding="6">
                <tr>
                    <th>管理区分</th>
                    <td>
                        <?php $admin=["0"=>"管理者", "1"=>"経理", "2"=>"社員"];?>
                        <select name="admin">
                            <?php foreach($admin as $key=>$val):?>
                                <option value="<?php echo $key;?>"><?php echo $val;?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>部署</th>
                    <td>
                        <select name="busho">
                            <?php
                            foreach ($rec as $val) {
                                echo '<option value="' . $val['name'] . '">' . $val['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>スタッフ名</th>
                    <td><input type="text" name="name" style="width:200px;"></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" name="pass" style="width:200px" ;></td>
                </tr>
                <tr></tr>
            </table>
            <br>
            <div class="button">
                <input type="submit" value="登録">
            </div>
        </form>
        <br>
        <br>
        <a href="staff_list.php">リストへ戻る</a><br>
    </div>

</body>

</html>
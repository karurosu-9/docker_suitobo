<?php
session_start();
session_regenerate_id();

try {
    $disp_id = $_GET['id'];

    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);

    $sql = 'SELECT id,admin,busho,name FROM staff_list WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $disp_id;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <title>出納帳---詳細画面</title>
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

    .button {
        margin-left: 220px;
        margin-right: 10px;
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
        社員詳細<br>
        <br>
        <br>
        <script>
            function delete_check() {

                if (key_value == 'delete') {
                    var msg = confirm("この情報を削除してよろしいですか?");
                    return msg;
                }
            }
        </script>
        <form action="staff_branch.php" method="post" onsubmit="return delete_check()">
            <table cellpadding="6">
                <tr>
                    <th>社員番号</th>
                    <td><?php echo $rec['id']; ?></td>
                </tr>
                <tr>
                    <th>管理区分</th>
                    <td>
                        <?php
                        if ($rec['admin'] == 0) {
                            echo "管理者";
                        } else
                            if ($rec['admin'] == 1) {
                            echo "経理";
                        } else {
                            echo "社員";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>部署</th>
                    <td><?php echo $rec['busho']; ?></td>
                </tr>
                <tr>
                    <th>名前</th>
                    <td><?php echo $rec['name']; ?></td>
                </tr>
            </table>
            <br>
            <br>
            <input type="hidden" name="id" value="<?php echo $disp_id; ?>">
            <div class="button">
                <input type="submit" name="edit" value="修正" onclick="test_key_value='edit'">
                <input type="submit" name="delete" value="削除" onclick="key_value='delete'">
            </div>
            <input type="hidden" name="key" value="">
        </form>
        <br>
        <br>
        <a href="staff_list.php">リストへ戻る</a><br>
    </div>
</body>

</html>
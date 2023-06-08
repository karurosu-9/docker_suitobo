<?php
session_start();
session_regenerate_id();

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");

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
        white-space: nowrap;
    }

    th {
        border: black solid 2px;
        background-color: #a9a9a9;
    }

    td {
        border: black solid 2px;
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
                <th>登録する項目</th>
            </tr>
            <tr>
                <td>
                    <?php
                    if (empty($name) == true) {
                        echo '<span>※項目を入力してください。</span>';
                        $okflag = false;
                    } else {
                        echo $name;
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

                $sql = 'INSERT INTO kanjo_list(name) VALUES(?)';
                $stmt = $dbh->prepare($sql);
                $data[] = $name;
                $stmt->execute($data);

                $dbh = null;
            } catch (Exception $e) {
                $e->getMessage();
                echo "ただいま障害によりご迷惑をおかけしております。";
            }
        } else {
            echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
            exit;
        }

        ?>
        <script>
            alert("登録しました。");
            location.href = "kanjo_list.php";
        </script>
    </div>

</body>

</html>
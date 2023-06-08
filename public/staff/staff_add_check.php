<?php
session_start();
session_regenerate_id();

$admin = $_POST['admin'];
$busho = $_POST['busho'];
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");
$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, "UTF-8");

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
    }

    .button {
        margin-left: 95px;
        margin-right: 10px;
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
                <th>管理区分</th>
                <td>
                    <?php

                    if ($admin == 0) {
                        echo "管理者";
                    } else
                            if ($admin == 1) {
                        echo "経理";
                    } else {
                        echo "社員";
                    }

                    ?>
                </td>
            </tr>
            <tr>
                <th>部署</th>
                <td>
                    <?php
                    if ($busho == false) {
                        echo '<span>※部署を選択してください。<br></span>';
                        $okflag = false;
                    } else {
                        echo $busho;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>スタッフ名</th>
                <td>
                    <?php
                    if ($name == "") {
                        echo '<span>※名前を入力してください。</span>';
                        $okflag = false;
                    } else {
                        echo $name;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td>
                    <?php
                    if ($pass == '') {
                        echo '<span>※パスワードを入力してください。</span>';
                        $okflag = false;
                    } else
                        if (preg_match('/[0-9]+$/', $pass) == 0) {
                        echo '<span>※正しい数値で入力してください。</span>';
                        $okflag = false;
                    } else {
                        echo "*****";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <br>
        <?php
        if ($okflag == true) {
            try {
                $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
                $user = "root";
                $password = "root";
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = 'INSERT INTO staff_list(admin, busho, name, password) VALUES(?,?,?,?)';
                $stmt = $dbh->prepare($sql);
                $data[] = $admin;
                $data[] = $busho;
                $data[] = $name;
                $data[] = $pass;
                $stmt->execute($data);

                $dbh = null;
            } catch (Exception $e) {
                $e->getMessage();
                echo "ただいま障害によりご迷惑をおかけしております。";
            }
        } else {
            echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る<a/>';
        }

        ?>
    </div>
    <script>
        alert("登録しました。");
        location.href = "staff_list.php";
    </script>
</body>

</html>
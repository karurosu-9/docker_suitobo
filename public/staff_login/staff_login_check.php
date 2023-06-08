<?php
session_start();
session_regenerate_id();

try {

    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, "UTF-8");

    $dsn = 'mysql:host=db;dbname=suitobo;charset=utf8';
    $user = "root";
    $password = "root";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM staff_list WHERE name=? AND password=? ';
    $stmt = $dbh->prepare($sql);
    $data[] = $name;
    $data[] = $pass;
    $stmt->execute($data);

    $dbh = null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $e->getMessage();
    var_dump($e);
    exit;
    echo "ただいま障害によりご迷惑をおかけしております。";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>出納帳---ログイン画面</title>
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

    span {
        color: red;
        font-weight: bold;
    }
</style>

<body>
    <div class="body">
        <br>
        <br>
        <br>
            <table cellpadding="6">
                <tr>
                    <?php
                    if ($rec == false) {
                        echo '<th><span>※エラー</span></th>';
                        echo '<td><span>※名前とパスワードが一致しません。</span><br></td>';
                    } else {
                        $_SESSION['login'] = 0;
                        $_SESSION['staff_admin'] = $rec['admin'];
                        $_SESSION['staff_name'] = $name;
                        echo "ログインしました。<br>";
                        echo '<br>';
                        echo '<a href="staff_top.php">トップメニューへ</a>';
                        exit;
                    }
                    ?>
                </tr>
            </table>
            <br>
            <div class="button">
                <a href="staff_login.php">ログイン画面へ</a><br>
            </div>
    </div>
</body>

</html>
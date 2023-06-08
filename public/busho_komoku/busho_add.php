<?php
session_start();
session_regenerate_id();
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

    .button {
        margin-left: 270px;
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
        部署項目の登録<br>
        <br>
        <br>
        <script>
            function add_check() {
                var msg = confirm("この情報を登録しますか？");
                return msg;
            }
        </script>
        <form action="busho_add_check.php" method="post" onsubmit="return add_check();">
            <table cellpadding="6">
                <tr>
                    <th>登録する部署名を入力してください。</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="name" style="width:280px">
                    </td>
                </tr>
            </table>
            <br>
            <div class="button">
                <input type="submit" value="登録">
            </div>
        </form>
        <br>
        <br>
        <a href="busho_list.php">リストへ戻る</a><br>
    </div>
</body>

</html>
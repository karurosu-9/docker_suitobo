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
</style>

<body>
    <div class="body">
        <br>
        <br>
        <br>
        社員ログイン<br>
        <br>
        <br>
        <form action="staff_login_check.php" method="post">
            <table cellpadding="6">
                <tr>
                    <th>名前</th>
                    <td><input type="text" name="name" style="width:200px;"></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" name="pass" style="width:200px" ;></td>
                </tr>
            </table>
            <br>
            <div class="button">
                <input type="submit" value="ログイン">
            </div>
        </form>
    </div>
</body>

</html>
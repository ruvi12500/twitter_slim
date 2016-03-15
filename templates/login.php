<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Twitter Login</title>
</head>
<body>
    <h1>ログインページ</h1>
    <? if ($status == "logged_in") { ?>
        <p><a href="tweet.php">ログイン済みです。</a></p>
    <? } elseif ($status == "login") { ?>
        <p><a href="tweet.php">ログインに成功しました。</a></p>
    <? } elseif ($status == "failed") { ?>
        <p>メールアドレスもしくはパスワードが違います。</p>
    <? } else { ?>
        <form action="" method="post">
        MAILADDRESS:<input type="text" name="mailaddress"><br>
        PASSWORD:<input type="password" name="password"><br>
        <input type="submit" value="ログイン">
    </form>
    <? } ?>
</body>
</html>

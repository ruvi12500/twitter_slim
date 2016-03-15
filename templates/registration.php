<!DOCTYPE html>
<html>
<head>
    <title>ユーザー登録</title>
</head>
<body>
    <? if ($status == "ok") { ?>
        <p>新規登録完了</p>
    <? } elseif ($status == "failed") { ?>
        <p>既に存在するメールアドレスです。</p>
    <? } else { ?>
<form action="" method="post">
MAILADDRESS:
<input type="text" name="mail_address"><br>
PASSWOERD:
<input type="text" name="user_password"><br>
USER NAME:
<input type="text" name="user_name"><br>
<input type="submit" name="insert" value = "登録">
</form>
<? } ?>
</body>
</html>

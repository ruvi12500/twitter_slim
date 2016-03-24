<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>ユーザー登録</title>
</head>
<body>
    <? if ($status == "ok") { ?>
        <p><a href="/">新規登録完了</a></p>
    <? } elseif ($status == "failed") { ?>
        <p>セッションが一致しませんでした。</p>
    <? } else { ?>
    <form action="" method="post">
    PASSWOERD:
    <input type="password" name="user_password"><br>
    USER NAME:
    <input type="text" name="user_name"><br>
    <input type="submit" name="insert" value = "登録">
    </form>
    <? } ?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>メールアドレス登録</title>
</head>
<body>

<table>
<tr>
<? if ($status == 'ok') { ?>
<form action="registration/<?= $_SESSION['UniqUserId'] ?>" method="post">
    <p>メールを送信しました。</p>
<? } elseif ($status == 'failed') { ?>
    <p>既に登録されています。</p>
<? } else { ?>
<form action="" method="post">
    <td>メールアドレス：<input type="text" name="mail_address"></td>
    <td><input type="submit"></td>
<? } ?>
</tr>
</table>
</form>
</body>
</html>

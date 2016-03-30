<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>ツイート編集画面</title>
</head>
<body>

<form action="" method="post">
<? if (!empty($display)) { ?>
    <? foreach ($display as $t) { ?>
     <?= htmlspecialchars($t['body'],ENT_QUOTES) ?><br>
    <? } ?>
<? } ?>
<input type="text" name="update">
<input type="submit" value = "確定">
<br>
<a href="/tweet">戻る</a>
</form>
</body>
</html>

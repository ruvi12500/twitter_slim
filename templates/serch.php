<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>検索結果</title>
</head>
<body>
<table>
<? if (!empty($Serch)) { ?>
    <? foreach ($Serch as $s) { ?>
        <tr><td>
        <?= htmlspecialchars($s['body'],ENT_QUOTES) ?>
        <?= htmlspecialchars($s['user_name'],ENT_QUOTES) ?>
        <?= $s['created_at'] ?>
        <? if ($_SESSION['user_id'] != $s['user_id']) { ?>
            <a href="follow/<?= $s['user_id'] ?>">フォローする</a>
        <? } ?>
        </td></tr>
    <? } ?>
<? } ?>
</table>
<a href = '/tweet'>戻る</a>
</body>
</html>

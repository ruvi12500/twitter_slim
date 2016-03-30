<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>フォロー</title>
</head>
<body>
<table>
<? if(!empty($follows)){ ?>
    <? foreach ($follows as $f) { ?>
            <tr><td>
            <a href="users/<?= $f['user_name'] ?>">
                <?= htmlspecialchars($f['user_name'],ENT_QUOTES) ?>
            </a>
            </td></tr>
    <? } ?>
<? } ?>
</table>
<a href="/tweet">戻る</a>
</body>
</html>

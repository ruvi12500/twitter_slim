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
            <?= htmlspecialchars($f['user_name'],ENT_QUOTES) ?>
            </td></tr>
    <? } ?>
<? } ?>
</table>
<a href="/tweet">戻る</a>
</body>
</html>

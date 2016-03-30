<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<form>
<table>
<? if (!empty($display)) { ?>
    <? foreach ($display as $t) { ?>
        <tr><td>
        <?= htmlspecialchars($t['body'],ENT_QUOTES) ?>
        <?= htmlspecialchars($t['user_name'],ENT_QUOTES) ?>
        <?= $t['created_at'] ?>
        </td></tr>
        <tr><td>
        <? if(!empty($t['name'])){ ?>
            <a href = "http://local-twitter-slim.jp/images/<?= $t['name']?>" >
                <img src="http://local-twitter-slim.jp/images/<?= $t['name']?>" >
            </a>
        <? } ?>

        </td></tr>
    <? } ?>
<? } ?>
</table>
</form>
</body>
</html>

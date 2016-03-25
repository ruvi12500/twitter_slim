<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Twitter履歴</title>
</head>
<body>
<form action="" method="POST">
<table>
<? if(!empty($history)){ ?>
    <? foreach ($history as $list) { ?>
        <tr><td>
        <?= htmlspecialchars($list['body'],ENT_QUOTES) ?>
        <?= $list['created_at'] ?>
        <? if ($list["delete_flag"] == 1) { ?>
            削除されています。
        <? } ?>
        </td></tr>

        <tr><td>
        <? if (!empty($list['id'])) { ?>
            <a href="/images/<?= $list['tweet_id'] ?>">
                <img src="/images/<?= $list['tweet_id'] ?>">
            </a>
        <? } ?>
        </td></tr>
    <? } ?>
<? } ?>
</form>
</table>
<a href="tweet">戻る</a>
</body>
</html>

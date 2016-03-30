<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>お気に入り一覧</title>
</head>
<body>
<form>
<table>
<? if (!empty($favorites)) { ?>
    <? foreach ($favorites as $list) { ?>
            <tr><td>
            <?= htmlspecialchars($list['body'],ENT_QUOTES) ?>
            <?= htmlspecialchars($list['user_name'],ENT_QUOTES) ?>
            <a href="/favorited/delete/<?= $list['tweet_id'] ?>">お気に入り解除</a>
            </td></tr>
        <tr><td>
        <? if(!empty($list['id'])){ ?>
            <a href="/images/<?= $list['name'] ?>">
                <img src="http://local-twitter-slim.jp/images/<?= $list['name'] ?>">
            </a>
        <? } ?>
        </td></tr>
    <? } ?>
<? } ?>
</table>
<a href="tweet">戻る</a>
</form>
</body>
</html>

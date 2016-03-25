<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>検索結果</title>
</head>
<body>
<table>
<? if (!empty($Search)) { ?>
    <? foreach ($Search as $s) { ?>
        <tr><td>
        <?= htmlspecialchars($s['body'],ENT_QUOTES) ?>
        <?= htmlspecialchars($s['user_name'],ENT_QUOTES) ?>
        <?= $s['created_at'] ?>
        <? if ($_SESSION['user_id'] != $s['user_id']) { ?>
            <a href="follow/<?= $s['user_id'] ?>">フォローする</a>
        <? } ?>
        </td></tr>

        <tr><td>
        <? if (!empty($s['id'])) { ?>
            <a href = "images/<?= $s['tweet_id']?>">
                <img src="http://local-twitter-slim.jp/images/<?= $s['tweet_id']?>" >
            </a>
        <? } ?>
        </td></tr>
    <? } ?>
<? } ?>
</table>
<a href = '/tweet'>戻る</a>
</body>
</html>

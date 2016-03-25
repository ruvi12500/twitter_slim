<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Twitter</title>
</head>
<body>
<table>
<tr>
<form action="tweet/insert" method="post">
    <td><input type="submit" value="ツイート"></td>
</form>
    <td><a href="history">ツイート履歴</a></td>
</tr>
<tr>
        <td><a href="favorited">お気に入り一覧</a></td>
    <form action="/search" method="post">
        <td><input type="text" name="search">
        <input type="submit" value="検索"></td>
    </form>
</tr>
<tr>
        <td><a href="follow">フォロー</a></td>
        <td><a href="follower">フォロワー</a></td>
</tr>
<tr>
<form action="logout" method="post">
    <td><input type="submit" value="ログアウト"></td>
</form>
</tr>
</table>
<h1>ツイート一覧</h1>
<table>
<? if (!empty($Display))  { ?>
    <? foreach ($Display as $t) { ?>
        <tr><td>
        <?= htmlspecialchars($t['body'],ENT_QUOTES) ?>
        <?= htmlspecialchars($t['user_name'],ENT_QUOTES) ?>
        <?= $t['created_at'] ?>
        <? if ($_SESSION['user_id'] == $t['user_id']) { ?>
            <a href="tweet/delete/<?= $t['tweet_id'] ?>">削除</a>
            <a href="update/<?= $t['tweet_id'] ?>">編集</a>
        <? } ?>
        <a href="tweet?tweet_id=<?= $t['tweet_id'] ?>">お気に入り</a>
        <? if ($_SESSION['user_id'] != $t['user_id']) { ?>
            <a href="tweet?retweet_id=<?= $t['tweet_id'] ?>">リツイート</a>
        <? } ?>
        </td></tr>
        <tr><td>
        <? if(!empty($t['id'])){ ?>
            <a href = "images/<?= $t['tweet_id']?>">
                <img src="http://local-twitter-slim.jp/images/<?= $t['tweet_id']?>" >
            </a>
        <? } ?>

        </td></tr>
    <? } ?>
<? } ?>
</table>

</body>
</html>

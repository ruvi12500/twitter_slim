<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Twitter</title>
</head>
<body>
<form action="tweet/insert" method="post">
    <input type="submit" value="ツイート"><br><br>
</form>
<form action="history" method="post">
    <input type="submit" value="ツイート履歴">
</form>
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
    <? } ?>
<? } ?>
</table>
<table>
<tr>
    <form action="favorited" method="post">
        <td><input type="submit" value="お気に入り一覧"></td>
    </form>
    <form action="/serch" method="post">
        <td><input type="text" name="serch">
        <input type="submit" value="検索"></td>
    </form>
</tr>
<tr>
    <form action="follow" method="post">
        <td><input type="submit" value="フォロー"></td>
    </form>
    <form action="follower" method="post">
        <td><input type="submit" value="フォロワー"></td>
    </form>
</tr>
<tr>
<form action="logout" method="post">
    <td><input type="submit" value="ログアウト"></td>
</form>
</tr>
</table>
</body>
</html>

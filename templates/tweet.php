<!DOCTYPE html>
<html>
<head>
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
<? foreach ($tweet_list as $t) { ?>
    <tr><td>
    <?= $t['body'] ?>
    <?= $t['user_name'] ?>
    <?= $t['created_at'] ?>
    <a href="tweet?id=<?= $t['tweet_id'] ?>">削除</a>
    <a href="update?id=<?= $t['tweet_id'] ?>">編集</a>
    <a href="tweet?tweet_id=<?= $t['tweet_id'] ?>">お気に入り</a>
    </td></tr>
<? } ?>
</table>
<form action="favorited" method="post">
    <input type="submit" value="お気に入り一覧">
</form>
<form action="follow_user_list" method="post">
    <input type="submit" value="フォローしにいく">
</form>
<form action="logout" method="post">
    <input type="submit" value="ログアウト">
</form>
</body>
</html>

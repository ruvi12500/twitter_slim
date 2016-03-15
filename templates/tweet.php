<!DOCTYPE html>
<html>
<head>
    <title>Twitter</title>
</head>
<body>
<form action="" method="get">
<input type="text" name="tweet">
<input type="submit" name='tweetbtn' value="ツイート"><br>
<a href="history.php">ツイート履歴</a>
<h1>ツイート一覧</h1>
<table>

<? echo $tweet_list; ?>

</table>
</form>
<form action="favorited.php" method="post">
<input type="submit" value="お気に入り一覧">
</form>
<form action="follow_user_list.php" method="post">
<input type="submit" value="フォローしにいく">
</form>
<a href="logout.php">ログアウト</a>
</body>
</html>

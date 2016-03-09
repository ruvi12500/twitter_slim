<!DOCTYPE html>
<html>
<head>
	<title>Tweet編集画面</title>
</head>
<body>

<form action="" method="POST">
<input type="text" name="update">
<input type="submit" name="updatebtn" value = "確定">
<? $update_class->tweet_update($update_class->getTweetUpdate(),$update_class->getTweetId()); ?>
<br>
<a href="tweet.php">戻る</a>
</form>
</body>
</html>

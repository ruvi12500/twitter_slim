<!DOCTYPE html>
<html>
<head>
    <title>Twitter</title>
</head>
<body>
<form action="" method="POST">
<input type="text" name="tweet">
<input type="submit" name='tweetbtn' value="ツイート"><br>
<a href="history.php">履歴</a>
<h1>ツイート一覧</h1>
<table>

    <? $tweet_class->tweet_post($tweet_class->getTweet(),$tweet_class->getTweetBtn()); ?>
    <? $tweet_class->tweet_delete($tweet_class->getTweetDelete()); ?>
    <? $tweet_class->tweet_list(); ?>

</table>
</form>
</body>
</html>

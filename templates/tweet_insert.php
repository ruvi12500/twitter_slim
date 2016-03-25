<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>ツイート</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="tweet"><br>
    <input type="file" name="image">
    <input type="hidden" name="maxFileSize" value="65535" />
    <input type="submit" name="TweetButton" value="ツイートする">
</form>
<br>
<a href="/tweet">戻る</a>
</body>
</html>

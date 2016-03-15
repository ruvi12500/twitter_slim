<!DOCTYPE html>
<html>
<head>
	<title>Tweet編集画面</title>
</head>
<body>

<form action="" method="get">
<input type="text" name="update">
<input type="submit" name="updatebtn" value = "確定">
<input type="hidden" name="id" value="<?= $_GET['id']; ?>" >
<br>
<a href="tweet">戻る</a>
</form>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<? foreach ($follows as $f) { ?>
        <?= $f['user_name']; ?>
        <a href="follow_user_list">フォローする</a>
<? } ?>
</body>
</html>

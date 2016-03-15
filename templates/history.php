<!DOCTYPE html>
<html>
<head>
    <title>Twitter履歴</title>
</head>
<body>
<form action="" method="POST">
<table>
<? foreach ($history as $list) { ?>
    <tr><td>
    <?= $list['body'] ?>
    <?= $list['created_at'] ?>
    <? if($list["delete_flag"] == 1) { ?>
        削除されています。
    <? } ?>
    </td></tr>
<? } ?>
</form>
</table>
<a href="tweet">戻る</a>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Twitter</title>
</head>
<body>
<table>
<form action="tweet/insert" method="post" enctype="multipart/form-data">
    <td><input type="text" name="tweet"></td>
    <tr>
    <td><input type="file" name="image"></td>
    <input type="hidden" name="maxFileSize" value="65535" />
    <td><input type="submit" name="TweetButton" value="ツイート"></td>
    </tr>
</form>
<tr>
    <td><a href="users/<?= $_SESSION['user_name']; ?>">マイプロフィール</a></td>
</tr>
<tr>
        <td><a href="favorited">お気に入り一覧</a></td>
    <form action="/search" method="get">
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
<? if (!empty($display)) { ?>
    <? foreach ($display as $t) { ?>
        <tr><td>

        <? if (preg_match('/[^#]+/',$t['body'],$Tweet)) { ?>
            <a href="tweet/<?= $t['tweet_id'] ?>">
                <?= htmlspecialchars($Tweet[0],ENT_QUOTES) ?>
            </a>
        <? } ?>

        <? if (preg_match_all('/#[a-z-0-9A-Z]+/',$t['body'],$hashTag)) { ?>
            <? foreach ($hashTag[0] as $tags) { ?>
                <a href="/search?search=<?= urlencode($tags); ?>">
                    <?= $tags ?>
                </a>
            <? } ?>
        <? } ?>

        <a href="users/<?= $t['user_name'] ?>">
            <?= htmlspecialchars($t['user_name'],ENT_QUOTES) ?>
        </a>
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

        <? if(!empty($t['name'])){ ?>
            <a href = "http://local-twitter-slim.jp/images/<?= $t['name']?>">
                <img src="http://local-twitter-slim.jp/images/<?= $t['name']?>" >
            </a>
        <? } ?>

        </td></tr>
    <? } ?>
<? } ?>
</table>
</body>
</html>

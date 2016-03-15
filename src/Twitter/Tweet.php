<?

namespace Twitter;

class Tweet
{
    private $tweet = null;
    private $tweetbtn = null;
    private $deletebtn = null;
    private $tweet_id = null;

    public function setTweet($tweet)
    {
        $this->tweet = (string)filter_var($tweet);
    }
    public function getTweet()
    {
        return $this->tweet;
    }

    public function setTweetBtn($tweetbtn)
    {
        $this->tweetbtn = $tweetbtn;
    }
    public function getTweetBtn()
    {
        return $this->tweetbtn;
    }

    public function setTweetDelete($deletebtn)
    {
        $this->deletebtn = $deletebtn;
    }
    public function getTweetDelete()
    {
        return $this->deletebtn;
    }

    public function setTweetFavorite($tweet_id)
    {
        $this->tweet_id = (string)filter_var($tweet_id);
    }
    public function getTweetFavorite()
    {
        return $this->tweet_id;
    }

    public function tweet_list()
    {
        $Tweeted = 0;
        $connect_db = new Database();
        try {
            $db= $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $query =
        "SELECT * FROM tweets join users
        on tweets.user_id = users.user_id ORDER BY tweets.created_at desc";
        if ($result = $db->query($query)) {
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['delete_flag'] == $Tweeted) { ?>
                    <tr><td>
                    <?= $row['body'] ?>
                    <?= $row['created_at'] ?>
                    <?= $row['user_name'] ?>
                    <a href="tweet.php?id=<?= $row['tweet_id'] ?> ">削除</a>
                    <a href="update.php?id=<?= $row['tweet_id'] ?> ">編集</a>
                    <a href="tweet.php?tweet_id=<?= $row['tweet_id'] ?> ">お気に入り</a>
                    </td></tr>
                <? }
            }
        }
    }

    public function tweet_add($tweet,$tweetbtn)
    {
        if (isset($tweet) && isset($tweetbtn)) {
            $connect_db = new Database();
            try {
                $db = $connect_db->connect_db();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            if (!isset($_SESSION)) {
                session_start();
            }

            $Tweeted = 0;
            $insert = $db->prepare(
                "insert into tweets
                (user_id,body,delete_flag)
                VALUE(?,?,?)"
            );
            $insert->execute(array($_SESSION['user_id'],$tweet,$Tweeted));
        }
    }

    public function tweet_delete($tweet_id)
    {
        if (isset($tweet_id)) {
            $connect_db = new Database();
            try {
                $db= $connect_db->connect_db();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            $Deleted = 1;
            $delete = $db->prepare(
                "update tweets set delete_flag = $Deleted WHERE tweet_id = ?"
            );
            $delete->execute(array($tweet_id));
        }
    }

    public function tweet_favorite($tweet_id){
        $connect_db = new Database();
        try {
            $db= $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $insert = $db->prepare(
            "insert into favorites
            (user_id,tweet_id)
            VALUE(?,?)"
        );
        $insert->execute(array($_SESSION['user_id'],$tweet_id));
    }
}

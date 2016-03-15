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
        $this->tweet = $tweet;
        return $this;
    }

    public function getTweet()
    {
        return $this->tweet;
    }

    public function setTweetDelete($deletebtn)
    {
        $this->deletebtn = $deletebtn;
        return $this;
    }

    public function getTweetDelete()
    {
        return $this->deletebtn;
    }

    public function setTweetFavorite($tweet_id)
    {
        $this->tweet_id = $tweet_id;
        return $this;
    }

    public function getTweetFavorite()
    {
        return $this->tweet_id;
    }

    public function setTweetButton($TweetButton)
    {
        $this->TweetButton = $TweetButton;
        return $this;
    }

    public function getTweetButton()
    {
        return $this->TweetButton;
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
        "SELECT tweets.*,users.user_name FROM tweets
        join users on tweets.user_id = users.user_id
        ORDER BY tweets.created_at desc";
        if ($result = $db->query($query)) {
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['delete_flag'] == $Tweeted) {
                    $array[] = $row;
                }
            }
        }
        return $array;
    }

    public function insert()
    {
        $TweetButton = $this->getTweetButton();
        if(isset($TweetButton)){
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
            $insert->execute(array($_SESSION['user_id'],$this->getTweet(),$Tweeted));
            $status = ('tweeted');
            return $status;
        }
    }

    public function tweet_delete()
    {
        $tweet_id = $this ->getTweetDelete();
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
        return $this;
    }

    public function tweet_favorite(){
        $tweet_id = $this->getTweetFavorite();
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

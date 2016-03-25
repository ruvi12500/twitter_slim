<?

namespace Twitter;

class Tweet extends AuthCheck
{
    private $tweet = null;
    private $tweetbtn = null;
    private $DeleteId = null;
    private $TweetId = null;
    private $TweetUpdate = null;
    private $status = 'none';

    public function setTweet($tweet)
    {
        $this->tweet = $tweet;
        return $this;
    }

    public function getTweet()
    {
        return $this->tweet;
    }

    public function setTweetDeleteId($DeleteId)
    {
        $this->DeleteId = $DeleteId;
        return $this;
    }

    public function getTweetDeleteId()
    {
        return $this->DeleteId;
    }

    public function setTweetFavoriteId($FavoriteId)
    {
        $this->FavoriteId = $FavoriteId;
        return $this;
    }

    public function getTweetFavoriteId()
    {
        return $this->FavoriteId;
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

    public function setTweetUpdate($TweetUpdate)
    {
        $this->TweetUpdate = $TweetUpdate;
        return $this;
    }

    public function getTweetUpdate()
    {
        return $this->TweetUpdate;
    }

    public function setTweetUpdateId($TweetId)
    {
        $this->TweetId = ($TweetId);
        return $this;
    }

    public function getTweetUpdateId()
    {
        return $this->TweetId;
    }

    public function setReTweetId($TweetId)
    {
        $this->TweetId = ($TweetId);
        return $this;
    }

    public function getReTweetId()
    {
        return $this->TweetId;
    }

    public function setTweetSearch($TweetSearch)
    {
        $this->TweetSearch = ($TweetSearch);
        return $this;
    }

    public function getTweetSearch()
    {
        return $this->TweetSearch;
    }

    public function setMaxFileSize($maxFileSize)
    {
        $this->maxFileSize = ($maxFileSize);
        return $this;
    }

    public function getMaxFileSize()
    {
        return $this->maxFileSize;
    }

    public function display()
    {
        $Tweeted = 0;
        $UserId = $_SESSION['user_id'];
        $connect_db = new Database();
        $db= $connect_db->connect_db();
        $stmt = $db->prepare(
            "SELECT
                tweets.*,
                users.user_name,
                images.id
            FROM tweets
            LEFT JOIN follows ON tweets.user_id = followed_user_id
            LEFT JOIN images ON tweets.tweet_id = images.tweet_id
            JOIN users ON tweets.user_id = users.user_id
            WHERE follows.user_id = ? OR tweets.user_id = ?
            UNION SELECT
                retweets.tweet_id,
                tweets.user_id,
                tweets.body,
                tweets.delete_flag,
                retweets.created_at,
                retweets.updated_at,
                users.user_name,
                images.id
            FROM retweets
            LEFT JOIN tweets ON tweets.tweet_id = retweets.tweet_id
            LEFT JOIN follows ON retweets.user_id = follows.followed_user_id
            LEFT JOIN images ON retweets.tweet_id = images.tweet_id
            JOIN users ON tweets.user_id = users.user_id
            WHERE retweets.user_id = ? OR follows.user_id = ?
            ORDER BY created_at desc"
        );
        $stmt->execute([$UserId,$UserId,$UserId,$UserId]);
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['delete_flag'] == $Tweeted) {
                    $array[] = $row;
                }
            }
        if (!empty($array)) {
            return $array;
        }
    }

    public function insert()
    {
        $TweetButton = $this->getTweetButton();
        $maxFileSize = $this->getMaxFileSize();
        if (
            isset($TweetButton) &&
            $_FILES['image']['size'] < $maxFileSize)
        {
            $connect_db = new Database();
            $db = $connect_db->connect_db();
            $Tweeted = 0;
            $query = [$_SESSION['user_id'],$this->getTweet(),$Tweeted];

            $insert = $db->prepare(
                "insert into tweets
                (user_id,body,delete_flag)
                VALUE(?,?,?)"
            );
            $insert->execute($query);
            $tweetId = $db->lastInsertId('tweet_id');

            if($_FILES['image']['tmp_name'] != ''){
                $imageName = md5($_FILES['image']['name'])  ;
                $image = file_get_contents($_FILES['image']['tmp_name']);
                $imagequery = [$tweetId,$imageName,$image];
                $insert = $db->prepare(
                    'INSERT INTO images (tweet_id,name,data) VALUE(?,?,?)'
                );
                $insert->execute($imagequery);
            }
            return true;
        }
    }

    public function delete()
    {
        $TweetDeleteId = $this->getTweetDeleteId();

        if (isset($TweetDeleteId)) {
            $connect_db = new Database();
            $db= $connect_db->connect_db();
            $Deleted = 1;
            $delete = $db->prepare(
                "UPDATE tweets set delete_flag = $Deleted
                WHERE tweet_id = ? AND user_id = ?"
            );
            $delete->execute([$TweetDeleteId,$_SESSION['user_id']]);
        }
    }

    public function update()
    {
        $TweetUpdate = $this->getTweetUpdate();
        $TweetUpdateId = $this->getTweetUpdateId();

        if (isset($TweetUpdate)) {
            $connect_db = new Database();
            $db = $connect_db->connect_db();

            $update = $db->prepare(
                "UPDATE tweets SET body = ? WHERE tweet_id = ? AND user_id = ?"
            );

            $update->execute([
                $TweetUpdate,
                $TweetUpdateId,
                $_SESSION['user_id']
            ]);

        }
    }

    public function history()
    {
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        $stmt = $db->prepare(
            'SELECT tweets.*,images.id
            FROM tweets
            LEFT JOIN images ON tweets.tweet_id = images.tweet_id
            WHERE user_id = ?
            ORDER BY created_at DESC;'
        );
        $stmt->execute([$_SESSION['user_id']]);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $history[] = $row;
        }
        if (!empty($history)) {
            return $history;
        }
    }

    public function favorite()
    {
        $FavoriteId = $this->getTweetFavoriteId();
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        $insert = $db->prepare(
            "insert into favorites
            (user_id,tweet_id)
            VALUE(?,?)"
        );
        $insert->execute([$_SESSION['user_id'],$FavoriteId]);
        return $this;
    }

    public function retweet()
    {
        $RetweetId = $this->getRetweetId();
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        $insert = $db->prepare(
            "insert into retweets
            (user_id,tweet_id)
            VALUE(?,?)"
        );
        $insert->execute([$_SESSION['user_id'],$RetweetId]);
    }

    public function search()
    {
        $TweetSearch = $this->getTweetSearch();
        $connect_db = new Database();
        $db = $connect_db->connect_db();

        $Keyword = str_replace("　", " ", $TweetSearch);
        $Keyword = trim($Keyword);
        $KeywordArray = preg_split("/[\s]+/",$Keyword);
        $sql = 'SELECT tweets.*,users.user_name,images.id FROM tweets
        JOIN users on tweets.user_id = users.user_id
        LEFT JOIN images ON tweets.tweet_id = images.tweet_id';
        $where = [];
        $bind = [];
        foreach ($KeywordArray as $value) {
            $where[] = '(body LIKE ?)';
            $bind[] = '%'.$value.'%';
        }
        $sql .= ' WHERE '
            .implode('AND', $where)
            .'AND delete_flag = 0 ORDER BY tweets.created_at desc';
        $search = $db -> prepare($sql);
        $search -> execute($bind);
        while ($row = $search->fetch(\PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }
        if (!empty($array)) {
            return $array;
        }
    }
}

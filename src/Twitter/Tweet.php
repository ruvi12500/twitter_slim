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
    private $Tweeted = 0;

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
        $UserId = $_SESSION['user_id'];
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        $stmt = $db->prepare(
            'SELECT
                tweets.*,
                users.user_name,
                images.name
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
                images.name
            FROM retweets
            LEFT JOIN tweets ON tweets.tweet_id = retweets.tweet_id
            LEFT JOIN follows ON retweets.user_id = follows.followed_user_id
            LEFT JOIN images ON retweets.tweet_id = images.tweet_id
            JOIN users ON tweets.user_id = users.user_id
            WHERE retweets.user_id = ? OR follows.user_id = ?
            ORDER BY created_at desc'
        );
        $stmt->execute([$UserId,$UserId,$UserId,$UserId]);

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['delete_flag'] == $this->Tweeted) {
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
            $_FILES['image']['size'] < $maxFileSize
        ){
            $connect_db = new Database();
            $db = $connect_db->connect_db();
            $query = [$_SESSION['user_id'],$this->getTweet(),$this->Tweeted];

            $insert = $db->prepare(
                'INSERT INTO tweets
                (user_id,body,delete_flag)
                VALUES(?,?,?)'
            );
            $insert->execute($query);
            $tweetId = $db->lastInsertId('tweet_id');

            if ($_FILES['image']['tmp_name'] != '') {
                $imageName = md5(uniqid(rand(100,999)));
                $image = file_get_contents($_FILES['image']['tmp_name']);
                $imagequery = [$tweetId,$imageName,$image];
                $insert = $db->prepare(
                    'INSERT INTO images (tweet_id,name,data) VALUES(?,?,?)'
                );
                $insert->execute($imagequery);
            }

            if (preg_match('/(#[a-z0-9A-Z]+\s*)+/',$this->getTweet(),$hashTag)) {
                $keywords = preg_split(
                    '/[\s]+/',
                    trim(str_replace('　', ' ', reset($hashTag)))
                );
                $sql ='INSERT INTO tags (tweet_id,hash_tag)';
                foreach ($keywords as $keyword) {
                    $values[] = '(?,?)';
                    $bind[] = $tweetId;
                    $bind[] = $keyword;
                }
                $sql .= ' VALUES '
                    . implode(',', $values);
                $insert = $db->prepare($sql);
                $insert -> execute($bind);
            }
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
                'UPDATE tweets set delete_flag = $Deleted
                WHERE tweet_id = ? AND user_id = ?'
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
                'UPDATE tweets SET body = ? WHERE tweet_id = ? AND user_id = ?'
            );

            $update->execute([
                $TweetUpdate,
                $TweetUpdateId,
                $_SESSION['user_id']
            ]);

        }
    }

    public function updateDisplay()
    {
        $TweetUpdateId = $this->getTweetUpdateId();
        $connect_db = new Database();
        $db = $connect_db->connect_db();

        $update = $db->prepare(
            'SELECT * FROM tweets WHERE tweet_id = ? AND user_id = ?'
        );

        $update->execute([
            $TweetUpdateId,
            $_SESSION['user_id']
        ]);

        while ($row = $update->fetch(\PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        if (!empty($array)) {
            return $array;
        }
    }

    public function favorite()
    {
        $FavoriteId = $this->getTweetFavoriteId();
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        $insert = $db->prepare(
            'INSERT INTO favorites
            (user_id,tweet_id)
            VALUES(?,?)'
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
            'INSERT INTO retweets
            (user_id,tweet_id)
            VALUES(?,?)'
        );
        $insert->execute([$_SESSION['user_id'],$RetweetId]);
    }

    public function search()
    {
        $TweetSearch = $this->getTweetSearch();
        $connect_db = new Database();
        $db = $connect_db->connect_db();

        if (preg_match('/(#[a-z-0-9A-Z]+\s*)+/',$TweetSearch,$hashTag)) {

            $Keyword = str_replace('　', ' ', $hashTag[0]);
            $Keyword = trim($Keyword);
            $KeywordArray = preg_split('/[\s]+/',$Keyword);
            $sql =
                'SELECT * FROM tags
                JOIN tweets ON tags.tweet_id = tweets.tweet_id
                JOIN users ON tweets.user_id = users.user_id
                LEFT JOIN images ON tags.tweet_id = images.tweet_id';
            $where = [];
            $bind = [];

            foreach ($KeywordArray as $value) {
                $where[] = '(hash_tag = ?)';
                $bind[] = $value;
            }
            $sql .= ' WHERE '
                .implode('OR', $where)
                .'GROUP BY tags.tweet_id ORDER BY tweets.created_at desc';
            $search = $db -> prepare($sql);
            $search -> execute($bind);

        } else {
            $Keyword = str_replace('　', ' ', $TweetSearch);
            $Keyword = trim($Keyword);
            $KeywordArray = preg_split('/[\s]+/',$Keyword);
            $sql =
                'SELECT tweets.*,users.user_name,images.name FROM tweets
                JOIN users on tweets.user_id = users.user_id
                LEFT JOIN images ON tweets.tweet_id = images.tweet_id';
            $where = [];
            $bind = [];

            foreach ($KeywordArray as $value) {
                $where[] = '(body LIKE ?)';
                $bind[] = '%'.$value.'%';
            }

            $sql .= ' WHERE '
                .implode('OR', $where)
                .'AND delete_flag = 0 ORDER BY tweets.created_at desc';
            $search = $db -> prepare($sql);
            $search -> execute($bind);
        }

        while ($row = $search->fetch(\PDO::FETCH_ASSOC)) {
            if ($row['delete_flag'] == $this->Tweeted) {
                $array[] = $row;
            }
        }

        if (!empty($array)) {
            return $array;
        }
    }

    public function Detail($id)
    {
        $connect_db = new Database();
        $db= $connect_db->connect_db();
        $stmt = $db->prepare(
            'SELECT tweets.*,users.user_name,images.name FROM tweets
            LEFT JOIN images ON tweets.tweet_id = images.tweet_id
            JOIN users ON tweets.user_id = users.user_id
            WHERE tweets.tweet_id = ?'
        );
        $stmt->execute([$id]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($row['delete_flag'] == $this->Tweeted) {
                $array[] = $row;
            }
        }

        if (!empty($array)) {
            return $array;
        }
    }
}

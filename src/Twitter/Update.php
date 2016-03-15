<?

namespace Twitter;

class Update
{
    private $tweet_update = null;
    private $tweet_id = null;

    public function setTweetUpdate($tweet_update)
    {
        $this->tweet_update = (string)filter_var($tweet_update);
    }
    public function getTweetUpdate()
    {
        return $this->tweet_update;
    }

    public function setTweetId($tweet_id)
    {
        $this->tweet_id = ($tweet_id);
    }
    public function getTweetId()
    {
        return $this->tweet_id;
    }

    public function tweet_put($tweet_update,$tweet_id)
    {
        if (isset($tweet_update)) {
            $connect_db = new Database();
            try {
                $db = $connect_db->connect_db();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            $update = $db->prepare(
                "update tweets set body = ? WHERE tweet_id = ?"
            );
            $update->execute(array($tweet_update,$tweet_id));
        }
    }
}

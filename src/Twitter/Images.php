<?

namespace Twitter;

class Images
{

    public function setTweetId($tweetId)
    {
        $this->tweetId = ($tweetId);
        return $this;
    }

    public function getTweetId()
    {
        return $this->tweetId;
    }

    public function display()
    {
        $connect_db = new Database();
        $db= $connect_db->connect_db();
        $stmt = $db->prepare("SELECT * FROM images WHERE tweet_id = ?");
        $stmt->execute([$this->getTweetId()]);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $image[] = $row;
        }
        if (!empty($image)) {
            return $image;
        }
    }
}
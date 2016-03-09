<?
class Update
{
    private $host = 'localhost';
    private $db_user = 'takumi_asai';
    private $db_pass = 'asataku';
    private $use_db = 'twitter';
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

    public function connect_db()
    {
        $mysqli = new mysqli(
            $this->host,
            $this->db_user,
            $this->db_pass,
            $this->use_db
        );
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error
                );
            }
        return $mysqli;
    }

    public function tweet_update($tweet_update,$tweet_id)
    {
        if (isset($tweet_update)) {
            $mysqli = $this->connect_db();
            $update = $mysqli->prepare(
                "update tweet set Tweet = ? WHERE ID = ?"
            );
            $update->bind_param(
                'si',
                $tweet_update,
                $tweet_id
            );
            $update->execute();
        }
    }
}

$update_class = new Update();
if (isset($_POST['update']) && isset($_POST['updatebtn'])) {
    $update_class->setTweetUpdate($_POST['update']);
    $update_class->setTweetId($_GET['id']);
}

include 'update_templates.php';

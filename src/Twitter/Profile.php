<?

namespace Twitter;

class Profile
{

    public function setUserName($userName)
    {
        $this->userName = ($userName);
        return $this;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function Display()
    {
        $connect_db = new Database();
        $db= $connect_db->connect_db();
        $stmt = $db->prepare(
            'SELECT users.user_name,tweets.*,images.name FROM users
            JOIN tweets ON users.user_id = tweets.user_id
            LEFT JOIN images ON tweets.tweet_id = images.tweet_id
            WHERE users.user_name = ? AND delete_flag = 0
            ORDER BY created_at desc'
        );

        $stmt->execute([$this->getUserName()]);
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        if (!empty($array)) {
            return $array;
        }
    }
}

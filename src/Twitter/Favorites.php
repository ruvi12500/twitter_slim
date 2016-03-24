<?

namespace Twitter;

class Favorites
{
    private $favorites = null;

    public function setFavoriteDeleteId($DeleteId)
    {
        $this->DeleteId = $DeleteId;
        return $this;
    }

    public function getFavoriteDeleteId()
    {
        return $this->DeleteId;
    }

    public function Display()
    {
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        if (!isset($_SESSION)) {
            session_start();
        }

        $stmt = $db->prepare(
            'SELECT * FROM favorites
            JOIN tweets ON favorites.tweet_id = tweets.tweet_id
            JOIN users ON tweets.user_id = users.user_id
            WHERE favorites.user_id = ?'
        );
        $stmt->execute(array($_SESSION['user_id']));
        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $favorites[] = $result;
        }
        if(!empty($favorites)){
            return $favorites;
        }
    }

    public function Delete()
    {
        $FavoriteDeleteId = $this->getFavoriteDeleteId();
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($FavoriteDeleteId)) {
            $connect_db = new Database();
            $db= $connect_db->connect_db();
            $delete = $db->prepare(
                "DELETE FROM favorites WHERE tweet_id = ? AND user_id = ?"
            );
            $delete->execute(array($FavoriteDeleteId,$_SESSION['user_id']));
        }
    }
}

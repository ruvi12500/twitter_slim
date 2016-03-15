<?

namespace Twitter;

class Favorites
{
    public function favorite_list()
    {
        $connect_db = new Database();
        try {
            $db= $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

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
        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) { ?>
            <tr><td>
            <?= $result['body']; ?>
            <?= $result['user_name']; ?>
            </td></tr>
        <? }
    }
}

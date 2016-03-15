<?

namespace Twitter;

class History
{
    public function tweet_history()
    {
        $connect_db = new Database();
        try {
            $db = $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        if (!isset($_SESSION)) {
            session_start();
        }

        $stmt = $db->prepare(
            'SELECT * FROM tweets
            WHERE user_id = ?'
        );
        $stmt->execute(array($_SESSION['user_id']));
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $history[] = $row;
        }
        return $history;
    }
}

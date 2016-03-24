<?

namespace Twitter;

class Follow
{
    public function setFollowUserId($UserId)
    {
        $this->UserId = ($UserId);
        return $this;
    }

    public function getFollowUserId()
    {
        return $this->UserId;
    }

    public function FollowList() {
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        if (!isset($_SESSION)) {
            session_start();
        }
        $stmt = $db->prepare(
            'SELECT * FROM follows
            JOIN users ON follows.followed_user_id = users.user_id
            WHERE follows.user_id = ?'
        );
        $stmt->execute(array($_SESSION['user_id']));
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $follows[] = $row;
        }
        if (!empty($follows)) {
            return $follows;
        }
    }

    public function FollowerList()
    {
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        if (!isset($_SESSION)) {
            session_start();
        }
        $stmt = $db->prepare(
            'SELECT * FROM follows
            JOIN users ON follows.user_id = users.user_id
            WHERE followed_user_id = ?;'
        );
        $stmt->execute(array($_SESSION['user_id']));
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $follows[] = $row;
        }
        if (!empty($follows)) {
            return $follows;
        }
    }

    public function Insert()
    {
        $user_id = $this->getFollowUserId();
        $connect_db = new Database();
        $db = $connect_db->connect_db();
        if (!isset($_SESSION)) {
            session_start();
        }
        $insert = $db->prepare(
            'insert into follows
            (user_id,followed_user_id)
            VALUE(?,?)'
        );
        $insert->execute(array($_SESSION['user_id'],$user_id));
    }
}

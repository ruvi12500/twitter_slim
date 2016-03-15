<?

namespace Twitter;

class Follow
{

    public function follow_list() {
        $connect_db = new Database();
        try {
            $db = $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
       $stmt = $db->prepare('SELECT * FROM users');
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $follows[] = $row;
        }
        return $follows;
    }

    public function follow_insert()
    {
        $connect_db = new Database();
        try {
            $db = $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $insert = $db->prepare(
            "insert into follows
            (user_id,followed_user_id)
            VALUE(?,?)"
        );
        $insert->execute(array($_SESSION['user_id'],$user_id));
    }
}

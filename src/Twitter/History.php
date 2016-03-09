<?
class History
{
    private $host = 'localhost';
    private $db_user = 'takumi_asai';
    private $db_pass = 'asataku';
    private $use_db = 'twitter';

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

    public function tweet_list()
    {
        $mysqli = $this->connect_db();
        $query = "SELECT * FROM tweet ORDER BY TweetDate desc;";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) { ?>
                <tr><td>
                    ツイート:
                    <?= $row["Tweet"]; ?>
                    日時：
                    <?= $row["TweetDate"]; ?>
                    <? if($row["DeleteFlg"] == 1) { ?>
                        削除されています。
                    <? } ?>
                </td></tr>
        <? }
        }
    }
}

$history_class = new History();

include 'history_templates.php';

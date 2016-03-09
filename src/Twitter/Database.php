<?

namespace Twitter;

class Database
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

}

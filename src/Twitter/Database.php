<?

namespace Twitter;

class Database
{
    private $dbhost="localhost";
    private $dbuser="takumi_asai";
    private $dbpass="asataku";
    private $dbname="twitter";

    public function connect_db()
    {
        $db_connection = new \PDO(
            "mysql:host=$this->dbhost;dbname=$this->dbname",
            $this->dbuser,
            $this->dbpass
        );
        return $db_connection;
    }
}

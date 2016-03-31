<?

namespace Twitter;

class Database
{
    private $dbhost= "localhost";
    private $dbuser= "takumi_asai";
    private $dbpass= "asataku";
    private $dbname= "twitter";

    public function connect_db()
    {
        try{
            $db_connection = new \PDO(
                "mysql:host=$this->dbhost;dbname=$this->dbname",
                $this->dbuser,
                $this->dbpass
            );
        }catch(PDOException $e){
            $log = $e->getMessage();
            $log -> setWriter(new \My\LogWriter());
        }
        return $db_connection;
    }
}

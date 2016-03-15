<?

namespace Twitter;

class Auth
{
    private $mailaddress = null;
    private $password = null;
    private $status = 'none';

    public function setMailAddress($mailaddress)
    {
        $this->mailaddress = $mailaddress;
        return $this;
    }

    public function getMailAddress()
    {
        return $this->mailaddress;
    }

    public function setPassWord($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassWord()
    {
        return $this->password;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function login_check()
    {
        $mailaddress = $this->getMailAddress();
        $password = $this->getPassWord();
        $connect_db = new Database();
        try {
            $db = $connect_db->connect_db();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION["user_id"])) {
            $this->setStatus('logged_in');
        } elseif (!empty($mailaddress) OR !empty($password)) {
            $stmt = $db->prepare(
                "SELECT * FROM users WHERE mail_address = ? AND user_password = ?"
            );
            $stmt->execute(array($mailaddress,$password));
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $stmt->fetchAll();

            if ($stmt->rowCount() == 1) {
                $_SESSION['user_id'] = $result['user_id'];
                $this->setStatus('login');
            } else {
                $this->setStatus('failed');
            }
        }
    }
}

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

    public function login()
    {
        $salt = '1e13081c8ea3c66c0181f0893e8c540d';
        $mailaddress = $this->getMailAddress();
        $password = $this->getPassWord();
        $connect_db = new Database();
        $db = $connect_db->connect_db();

        if (isset($_SESSION["user_id"])) {
            $this->setStatus('logged_in');
        } elseif (!empty($mailaddress) OR !empty($password)) {
            $passwordMd5 = md5($password . $salt);

            $stmt = $db->prepare(
                "SELECT * FROM users WHERE mail_address = ? AND user_password = ?"
            );
            $stmt->execute([$mailaddress,$passwordMd5]);
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

    public function logout()
    {
        session_destroy();
    }
}

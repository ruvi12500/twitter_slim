<?

namespace Twitter;

class Registration
{

    private $mail_address = null;
    private $user_password = null;
    private $user_name = null;
    private $status = 'none';

    public function setMailAddress($mail_address)
    {
        $this->mail_address = $mail_address;
    }
    public function getMailAddress()
    {
        return $this->mail_address;
    }

    public function setUserPassWord($user_password)
    {
        $this->user_password = $user_password;
    }
    public function getUserPassWord()
    {
        return $this->user_password;
    }

    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }
    public function getUserName()
    {
        return $this->user_name;
    }

    public function setStatus($status)
    {
        $this->status = (string)filter_var($status);
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function user_insert($mail_address,$user_password,$user_name)
    {
        if (!empty($mail_address) OR !empty($user_password)) {
            $connect_db = new Database();
            try {
                $db = $connect_db->connect_db();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            $insert = $db->prepare(
                "insert into users
                (mail_address,user_password,user_name)
                VALUE(?,?,?)"
            );
            if ($insert->execute(array($mail_address,$user_password,$user_name))) {
                $this->setStatus('ok');
            }
            else {
                $this->setStatus('failed');
            }
        }
    }
}

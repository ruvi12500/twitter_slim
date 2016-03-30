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
        return $this;
    }

    public function getMailAddress()
    {
        return $this->mail_address;
    }

    public function setUserPassWord($user_password)
    {
        $this->user_password = $user_password;
        return $this;
    }

    public function getUserPassWord()
    {
        return $this->user_password;
    }

    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
        return $this;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function setUniqId($UniqId)
    {
        $this->UniqId = $UniqId;
        return $this;
    }

    public function getUniqId()
    {
        return $this->UniqId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function register()
    {
        $MailAddress = $this->getMailAddress();
        if($MailAddress != '') {
            $connect_db = new Database();
            $db = $connect_db->connect_db();

            $stmt = $db->prepare(
                'SELECT * FROM users WHERE mail_address = ?'
            );

            $stmt->execute([$MailAddress]);
            $UniqUserId = uniqid(rand(100,999));
            $_SESSION['UniqUserId'] = $UniqUserId;
            $_SESSION['MailAddress'] = $MailAddress;

            if($stmt->rowCount() == 0){
                $this->setStatus('ok');
                mb_language('japanese');
                mb_internal_encoding('utf-8');
                $to = $MailAddress;
                $subject = 'テストメール';
                $message = '以下のURLより会員登録してください。\n'.
                'http://local-twitter-slim.jp/registration/$UniqUserId';
                $header = 'From:test@test.com';
                mail($to, $subject, $message, $header);
            } else {
                $this->setStatus('failed');
            }
        }
    }

    public function userInsert()
    {
        $salt = '1e13081c8ea3c66c0181f0893e8c540d';
        $MailAddress = $_SESSION['MailAddress'];
        $UserPassWord = $this->getUserPassWord();
        $UserName = $this->getUserName();
        $UniqId = $this->getUniqId();

        if (
            $UniqId == $_SESSION['UniqUserId'] &&
            $UserPassWord != '' &&
            $UserName != ''
        ) {
            $UserPassWordMd5 = md5($UserPassWord . $salt);
            $query = [
                $_SESSION['MailAddress'],
                $UserPassWordMd5,$UserName
            ];
            $connect_db = new Database();
            $db = $connect_db->connect_db();

            $insert = $db->prepare(
                'insert into users
                (mail_address,user_password,user_name)
                VALUE(?,?,?)'
            );

            if ($insert->execute($query)) {
                $this->setStatus('ok');
            }
            else {
                $this->setStatus('failed');
            }
        }else{
            $this->setStatus('failed');
        }
    }
}

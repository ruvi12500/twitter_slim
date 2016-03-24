<?
namespace Twitter;

class AuthCheck{
    private $status = 'none';
    public function LoginCheck()
    {
        if(!isset($_SESSION)){
            session_start();
        }
        if(!empty($_SESSION['user_id'])){
            $status = 'login';
        }else{
            $status = 'failed';
        }
        return $status;
    }
}

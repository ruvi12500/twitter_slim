<?
namespace Twitter;

class AuthCheck
{
    public function loginCheck()
    {
        return !empty($_SESSION['user_id']);
    }
}

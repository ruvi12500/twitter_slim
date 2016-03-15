<?
namespace twitter;

class Logout
{
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location:http://local-twitter-slim.jp');
    }
}

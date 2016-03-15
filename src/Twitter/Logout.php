<?
namespace twitter;

class Logout
{
    public function logout()
    {
        session_start();
        session_destroy();
    }
}

<?
    require 'vendor/autoload.php';

    $app = new \Slim\Slim();

    $app->get('/', function () use ($app) {
        $app->render('index.php');
    });

    $app->post('/login.php', function () use ($app) {
        $login_class = new Twitter\Login();

        if (isset($_POST['mailaddress']) && isset($_POST['password'])) {
            $login_class->setMailAddress($_POST['mailaddress']);
            $login_class->setPassWord($_POST['password']);
        }

        $login_class->login_check(
            $login_class->getMailAddress(),
            $login_class->getPassWord()
        );

        $status = $login_class->getStatus();
        $app->render('login.php',array('status'=>$status));

    });

    $app->get('/logout.php', function () use ($app) {
        $logout_class = new Twitter\Logout();
        $logout_class->logout();
    });

    $app->get('/tweet.php', function () use ($app) {
        $tweet_class = new Twitter\Tweet();
        if (isset($_GET['tweet']) && isset($_GET['tweetbtn'])) {
            $tweet_class->setTweet($_GET['tweet']);
            $tweet_class->setTweetBtn($_GET['tweetbtn']);
        }

        if (isset($_GET['id'])) {
            $tweet_class->setTweetDelete($_GET['id']);
        }

        if (isset($_GET['tweet_id'])) {
            $tweet_class->setTweetFavorite($_GET['tweet_id']);
        }

        $tweet_class->tweet_add(
            $tweet_class->getTweet(),
            $tweet_class->getTweetBtn()
        );

        $tweet_class->tweet_delete($tweet_class->getTweetDelete());
        $tweet_class->tweet_favorite($tweet_class->getTweetFavorite());
        $tweet_list = $tweet_class->tweet_list();

        $app->render('tweet.php',array('tweet_list'=>$tweet_list));
    });

    $app->get('/history.php', function () use ($app) {
        $history_class = new Twitter\History();
        $history_class->tweet_history();
        $app->render('history.php') ;
    });

    $app->get('/update.php', function () use ($app) {
        $update_class = new Twitter\Update();

        if (isset($_GET['update']) && isset($_GET['updatebtn'])) {
            $update_class->setTweetUpdate($_GET['update']);
            $update_class->setTweetId($_GET['id']);
        }

        $update_class->tweet_put (
            $update_class->getTweetUpdate(),
            $update_class->getTweetId()
        );

        $app->render('update.php') ;
    });

    $app->post('/registration.php', function () use ($app) {
        $registration_class = new Twitter\Registration();
        if (isset($_POST['insert'])) {
            $registration_class->setMailAddress($_POST['mail_address']);
            $registration_class->setUserPassWord($_POST['user_password']);
            $registration_class->setUserName($_POST['user_name']);
        }
        $registration_class->user_insert(
            $registration_class->getMailAddress(),
            $registration_class->getUserPassWord(),
            $registration_class->getUserName()
        );

        $status = $registration_class->getStatus();
        $app->render('registration.php',array('status'=>$status));

    });

    $app->post('/favorited.php', function () use ($app) {
        $favorites_class = new Twitter\Favorites();
        $favorites_class->favorite_list();
        $app->render('favorited.php');
    });



    $app->post('/follow_user_list.php', function () use ($app) {
        $follow_class = new Twitter\Follow();
        $follow_class->follow_list();
        $app->render('follow_user_list.php');
    });

    $app->run();

?>

<?
    require 'vendor/autoload.php';

    $app = new \Slim\Slim();

    $app->get('/', function () use ($app) {
        $app->render('index.php');
    });

    $app->post('/login', function () use ($app) {
        $LoginClass = new Twitter\Auth();
        $mailaddress = $app->request->Post('mailaddress');
        $password = $app->request->Post('password');
        $LoginClass
            ->setMailAddress($mailaddress)
            ->setPassWord($password)
            ->login_check();
        $status = $LoginClass->getStatus();
        if ($status == 'login') {
            $app->redirect('/tweet');
        }
        $app->render('login.php',array('status'=>$status));

    });

    $app->post('/logout', function () use ($app) {
        (new Twitter\Logout)->logout();
        $app->redirect('/');
    });

    $app->get('/tweet', function () use ($app) {
        $TweetClass = new Twitter\Tweet();
        /*
        if (isset($_GET['id'])) {
            $TweetClass->setTweetDelete($_GET['id']);
        }

        if (isset($_GET['tweet_id'])) {
            $TweetClass->setTweetFavorite($_GET['tweet_id']);
        }
        */

        $delete_id = $app->request->Get('id');
        $favorite_id = $app->request->Get('tweet_id');
        $TweetClass
            ->setTweetDelete($delete_id)
            ->setTweetFavorite($favorite_id)
            ->tweet_delete()
            ->tweet_favorite();
        $tweet_list = $TweetClass->tweet_list();

        $app->render('tweet.php',array('tweet_list'=>$tweet_list));
    });

    $app->post('/tweet/insert', function () use ($app) {
        $TweetClass = new Twitter\Tweet();
        $tweet = $app->request->Post('tweet');
        $TweetButton = $app->request->Post('TweetButton');
        $TweetClass
            ->setTweet($tweet)
            ->setTweetButton($TweetButton);
        $status = $TweetClass->insert();
        $app->render('tweet_insert.php');
        if($status == 'tweeted'){
            $app->redirect('/tweet');
        }
    });

    $app->get('/tweet/delete/', function () use ($app) {
    });
    $app->post('/history', function () use ($app) {
        $HistoryClass = new Twitter\History();
        $history = $HistoryClass->tweet_history();
        $app->render('history.php',array('history'=>$history));
    });

    $app->get('/update', function () use ($app) {
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

    $app->post('/registration', function () use ($app) {
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

    $app->post('/favorited', function () use ($app) {
        $favorites_class = new Twitter\Favorites();
        $favorites_class->favorite_list();
        $app->render('favorited.php');
    });



    $app->post('/follow_user_list', function () use ($app) {
        $follow_class = new Twitter\Follow();
        $follows = $follow_class->follow_list();
        $app->render('follow_user_list.php',array('follows' => $follows));
    });

    $app->run();

?>

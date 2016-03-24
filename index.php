<?
    require 'vendor/autoload.php';

    $app = new \Slim\Slim();

    $app->get('/', function () use ($app) {
        $AuthClass = new Twitter\AuthCheck();
        $status = $AuthClass->LoginCheck();
        if ($status == 'login') {
            $app->redirect('tweet');
        }
        $app->render('index.php');
    });

    $app->post('/login', function () use ($app) {
        $LoginClass = new Twitter\Auth();
        $mailaddress = $app->request->Post('mailaddress');
        $password = $app->request->Post('password');
        $LoginClass
            ->setMailAddress($mailaddress)
            ->setPassWord($password)
            ->Login();
        $status = $LoginClass->getStatus();
        if ($status == 'login' OR $status == 'logged_in') {
            $app->redirect('/tweet');
        }
        $app->render('login.php',array('status' => $status));
    });

    $app->post('/logout', function () use ($app) {
        (new Twitter\Auth)->logout();
        $app->redirect('/');
    });

    $app->get('/tweet', function () use ($app) {
        $TweetClass = new Twitter\Tweet();
        $status = $TweetClass->LoginCheck();
        if ($status == 'failed') {
            $app->redirect('/');
        }
        $FavoriteId = $app->request->Get('tweet_id');
        $ReTweetId = $app->request->Get('retweet_id');
        $TweetClass
            ->setTweetFavoriteId($FavoriteId)
            ->setReTweetId($ReTweetId)
            ->Favorite()
            ->Retweet();
        $Display = $TweetClass->Display();
        $app->render('tweet.php',array('Display' => $Display));
    });

    $app->post('/tweet/insert', function () use ($app) {
        $TweetClass = new Twitter\Tweet();
        $ImagesClass = new Twitter\Images();
        $status = $TweetClass->LoginCheck();
        if ($status == 'failed') {
            $app->redirect('/');
        }
        $tweet = $app->request->Post('tweet');
        $image = $app->request->Post('image');
        $TweetButton = $app->request->Post('TweetButton');
        $TweetClass
            -> setTweet($tweet)
            -> setTweetButton($TweetButton);
        (new Twitter\Images)
            -> setImage($image)
            -> Insert();
        $Tweeted = $TweetClass->Insert();
        $app->render('tweet_insert.php');
        if($Tweeted == 'tweeted'){
            $app->redirect('/tweet');
        }
    });

    $app->get('/tweet/delete/:tweet_id', function ($tweet_id) use ($app) {
        $TweetClass = new Twitter\Tweet();
        $status = $TweetClass->LoginCheck();
        if ($status == 'failed') {
            $app->redirect('/');
        }
        $TweetClass
            ->setTweetDeleteId($tweet_id)
            ->Delete();
        $app->redirect('/tweet');
    });

    $app->post('/history', function () use ($app) {
        $HistoryClass = new Twitter\Tweet();
        $status = $HistoryClass->LoginCheck();
        if ($status == 'failed') {
            $app->redirect('/');
        }
        $history = $HistoryClass->History();
        $app->render('history.php',array('history' => $history));
    });

    $app->get('/update/:tweet_id', function ($tweet_id) use ($app) {
        $app->render('update.php');
    });

    $app->post('/update/:tweet_id', function ($tweet_id) use ($app) {
        $UpdateClass = new Twitter\Tweet();
        $status = $TweetClass->LoginCheck();
        if ($status == 'failed') {
            $app->redirect('/');
        }
        $body = $app->request->Post('update');
        $UpdateClass
            ->setTweetUpdate($body)
            ->setTweetUpdateId($tweet_id)
            ->Update();
            $app->redirect('/tweet');
    });

    $app->post('/regist', function () use ($app) {
        $RegistrationClass = new Twitter\Registration();
        $MailAddress = $app->request->Post('mail_address');
        $RegistrationClass
            ->setMailAddress($MailAddress)
            ->Regist();
        $status = $RegistrationClass->getStatus();
        $app->render('mail_form.php',array('status' => $status));
    });

    $app->get('/registration/:UniqId', function ($UniqId) use ($app) {
            $status = null;
            $app->render('registration.php',array('status' => $status));
    });

    $app->post('/registration/:UniqId', function ($UniqId) use ($app) {
        $RegistrationClass = new Twitter\Registration();
        $UserPassWord = $app->request->Post('user_password');
        $UserName = $app->request->Post('user_name');
        $RegistrationClass
            ->setUserPassWord($UserPassWord)
            ->setUserName($UserName)
            ->setUniqId($UniqId)
            ->UserInsert();
        $status = $RegistrationClass->getStatus();
        $app->render('registration.php',array('status' => $status));
    });

    $app->post('/favorited', function () use ($app) {
        $FavoritesClass = new Twitter\Favorites();
        $favorites = $FavoritesClass->Display();
        $app->render('favorited.php',array('favorites' => $favorites));
    });

    $app->get('/favorited/delete/:FavoriteId', function ($FavoriteId) use ($app) {
        $FavoritesClass = new Twitter\Favorites();
        $FavoritesClass
            ->setFavoriteDeleteId($FavoriteId)
            ->Delete();
        $app->redirect('/tweet');
    });

    $app->post('/serch', function () use ($app) {
        $TweetClass = new Twitter\Tweet();
        $status = $TweetClass->LoginCheck();
        if ($status == 'failed') {
            $app->redirect('/');
        }
        $TweetSerch = $app->request->Post('serch');
        $TweetClass
            ->setTweetSerch($TweetSerch);
        $Serch = $TweetClass->Serch();
        $app->render('serch.php',array('Serch' => $Serch));
    });

    $app->post('/follow', function () use ($app) {
        $FollowClass = new Twitter\Follow();
        $follows = $FollowClass->FollowList();
        $app->render('follow_user_list.php',array('follows' => $follows));
    });

    $app->post('/follower', function () use ($app) {
        $FollowClass = new Twitter\Follow();
        $follows = $FollowClass->FollowerList();
        $app->render('follow_user_list.php',array('follows' => $follows));
    });

    $app->get('/follow/:id', function ($id) use ($app) {
        $FollowClass = new Twitter\Follow();
        $FollowClass
            ->setFollowUserId($id)
            ->Insert();
        $app->redirect('/tweet');
    });

    $app->run();

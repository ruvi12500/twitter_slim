<?
require 'vendor/autoload.php';

$app = new \Slim\Slim();

session_start();

$app->get('/', function () use ($app) {
    $AuthClass = new Twitter\AuthCheck();
    $status = $AuthClass->loginCheck();
    if ($status == true) {
        $app->redirect('tweet');
    }
    $app->render('index.php');
});

$app->post('/login', function () use ($app) {
    $LoginClass = new Twitter\Auth();
    $mailaddress = $app->request->post('mailaddress');
    $password = $app->request->post('password');
    $LoginClass
        ->setMailAddress($mailaddress)
        ->setPassWord($password)
        ->login();
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
    $status = $TweetClass->loginCheck();
    if ($status == false) {
        $app->redirect('/');
    }
    $FavoriteId = $app->request->get('tweet_id');
    $ReTweetId = $app->request->get('retweet_id');
    $TweetClass
        ->setTweetFavoriteId($FavoriteId)
        ->setReTweetId($ReTweetId)
        ->favorite()
        ->retweet();
    $Display = $TweetClass->display();
    $app->render('tweet.php',array('Display' => $Display));
});

$app->post('/images/', function () use ($app) {
    $ImageClass = new Twitter\Images();
    imagegif(imagecreatefromstring($ImageClass->display()[0]['data']));
    $app->response->header('Content-Type', 'image/gif');
});
$app->get('/images/:id', function ($id) use ($app) {
    $ImageClass = new Twitter\Images();
    $ImageClass -> setTweetId($id);
    imagegif(imagecreatefromstring($ImageClass->display()[0]['data']));
    $app->response->header('Content-Type', 'image/gif');
});

$app->post('/tweet/insert', function () use ($app) {
    $TweetClass = new Twitter\Tweet();
    $status = $TweetClass->loginCheck();

    if ($status == false) {
        $app->redirect('/');
    }

    $tweet = $app->request->post('tweet');
    $maxFileSize = $app->request->post('maxFileSize');
    $TweetButton = $app->request->post('TweetButton');
    $TweetClass
        -> setTweet($tweet)
        -> setMaxFileSize($maxFileSize)
        -> setTweetButton($TweetButton);
    $Tweeted = $TweetClass->insert();
    $app->render('tweet_insert.php');

    if ($Tweeted == true) {
        $app->redirect('/tweet');
    }
});

$app->get('/tweet/delete/:tweet_id', function ($tweet_id) use ($app) {
    $TweetClass = new Twitter\Tweet();
    $status = $TweetClass->loginCheck();

    if ($status == false) {
        $app->redirect('/');
    }
    $TweetClass
        ->setTweetDeleteId($tweet_id)
        ->delete();
    $app->redirect('/tweet');
});

$app->get('/history', function () use ($app) {
    $HistoryClass = new Twitter\Tweet();
    $status = $HistoryClass->loginCheck();
    if ($status == false) {
        $app->redirect('/');
    }
    $history = $HistoryClass->history();
    $app->render('history.php',array('history' => $history));
});

$app->get('/update/:tweet_id', function ($tweet_id) use ($app) {
    $app->render('update.php');
});

$app->post('/update/:tweet_id', function ($tweet_id) use ($app) {
    $UpdateClass = new Twitter\Tweet();
    $status = $UpdateClass->loginCheck();

    if ($status == false) {
        $app->redirect('/');
    }

    $body = $app->request->post('update');
    $UpdateClass
        ->setTweetUpdate($body)
        ->setTweetUpdateId($tweet_id)
        ->update();
        $app->redirect('/tweet');
});

$app->post('/registration', function () use ($app) {
    $RegistrationClass = new Twitter\Registration();
    $MailAddress = $app->request->post('mail_address');

    $RegistrationClass
        ->setMailAddress($MailAddress)
        ->register();
    $status = $RegistrationClass->getStatus();
    $app->render('mail_form.php',array('status' => $status));
});

$app->get('/registration/:UniqId', function ($UniqId) use ($app) {
        $status = null;
        $app->render('registration.php',array('status' => $status));
});

$app->post('/registration/:UniqId', function ($UniqId) use ($app) {
    $RegistrationClass = new Twitter\Registration();
    $UserPassWord = $app->request->post('user_password');
    $UserName = $app->request->post('user_name');

    $RegistrationClass
        ->setUserPassWord($UserPassWord)
        ->setUserName($UserName)
        ->setUniqId($UniqId)
        ->userInsert();

    $status = $RegistrationClass->getStatus();
    $app->render('registration.php',array('status' => $status));
});

$app->get('/favorited', function () use ($app) {
    $FavoritesClass = new Twitter\Favorites();
    $favorites = $FavoritesClass->display();
    $app->render('favorited.php',array('favorites' => $favorites));
});

$app->get('/favorited/delete/:FavoriteId', function ($FavoriteId) use ($app) {
    $FavoritesClass = new Twitter\Favorites();
    $FavoritesClass
        ->setFavoriteDeleteId($FavoriteId)
        ->delete();
    $app->redirect('/tweet');
});

$app->post('/search', function () use ($app) {
    $TweetClass = new Twitter\Tweet();
    $status = $TweetClass->loginCheck();
    if ($status == false) {
        $app->redirect('/');
    }
    $TweetSearch = $app->request->post('search');
    $TweetClass
        ->setTweetSearch($TweetSearch);
    $Search = $TweetClass->search();
    $app->render('search.php',array('Search' => $Search));
});

$app->get('/follow', function () use ($app) {
    $FollowClass = new Twitter\Follow();
    $follows = $FollowClass->FollowList();
    $app->render('follow_user_list.php',array('follows' => $follows));
});

$app->get('/follower', function () use ($app) {
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

session_write_close();

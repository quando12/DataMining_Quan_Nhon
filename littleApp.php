<?php
require_once('TwitterAPIExchange.php');




/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "845198613663772673-gnHP3ojnRm9WuuJ8Xkj9TP7JSfm8EZV",
'oauth_access_token_secret' => "IPMwtBXWLJpMI7Gk6wFbF829xbdLAEUJYPUAVhR8ZnWKQ",
'consumer_key' => "JdZKWjMwySSl1xgvjADbGlEot",
'consumer_secret' => "qHvmZwJWYeXFfjKJJDLthYuSpV8iLLsOgQvceVu3mN5Led82wz"
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$url_get_user = "https://api.twitter.com/1.1/users/lookup.json";
// $url = "https://api.twitter.com/1.1/statuses/show/939162725330051074.json";

$requestMethod = "GET";
if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "nikestore";}
if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 3;}
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$tweet = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);

if(isset($_POST['btnSubmit'])) { 
    
    $user1 = isset($_POST['user1']) ? $_POST['user1'] : '';
    $user2 = isset($_POST['user2']) ? $_POST['user2'] : '';
    $user3 = isset($_POST['user3']) ? $_POST['user3'] : '';
    $user4 = isset($_POST['user4']) ? $_POST['user4'] : '';
    $user5 = isset($_POST['user5']) ? $_POST['user5'] : '';

    $user_array = array();
    if(!empty($user1)) array_push($user_array,$user1);
    if(!empty($user2)) array_push($user_array,$user2);
    if(!empty($user3)) array_push($user_array,$user3);
    if(!empty($user4)) array_push($user_array,$user4);
    if(!empty($user5)) array_push($user_array,$user5);


    $user_array_from_api = array();
    foreach ($user_array as $key => $value) {
        $getfield_post = "?screen_name=$value&count=100";
        $tweet = json_decode($twitter->setGetfield($getfield_post)
        ->buildOauth($url, $requestMethod)
        ->performRequest(),$assoc = TRUE);

        $user_array_from_api[] = $tweet;

    }
       
       echo count($user_array_from_api) ;
       // echo '<pre>';print_r($user_array_from_api);die;
       $favorite_count = 0;
       $favorite_array = array();
    foreach ($user_array_from_api as $user_key => $user_array) {

        foreach ($user_array as $key => $value) {
            $favorite_count = $favorite_count + $value['favorite_count'];
            // count($user_array);
            // echo $favorite_count;die;
        }
        $favorite_tb = $favorite_count / count($user_array);
        $favorite_array[] = $favorite_tb;
        $favorite_count = 0;

    }

    $favorite_array = implode(' , ',$favorite_array);

}   







// echo '<pre>';print_r($tweet);die;

if(!empty($tweet["errors"][0]["message"]))
 {
 	echo "<h3>Sorry, there was a problem.</h3>
 	<p>Twitter returned the following error message:</p><p><em>".$tweet[errors][0]["message"]."</em></p>";
	exit();
}
// echo '<pre>';print_r($tweet);die;	
// $tweet_id_array = array();
// foreach($tweet as $items)
    // {
    	// $tweet_id_array[] = $items['id_str'];

        // echo "Time and Date of Tweet: ".$tweet['created_at']."<br />";          //Ngày tạo tweet
        // echo "Tweet text: ". $tweet['text']."<br />";                           //Nội dung tweet
        // echo "id_str: ". $tweet['user']['id_str']."<br />";                     //Tùy trường hợp là id của tweet or user
        // echo "Tweeted by: ". $tweet['user']['name']."<br />";                   //Tên của người tạo tweet
        // echo "Screen name: ". $tweet['user']['screen_name']."<br />";           //username của người tạo tweet - có thể thay đổi
        // echo "Total Followers: ". $tweet['user']['followers_count']."<br />";   //Tổng số người theo dõi tài khoản hiện thời
        // echo "Friends: ". $tweet['user']['friends_count']."<br />";             //Tổng số người tài khoản hiện thời đang theo dõi
        // echo "Listed: ". $tweet['user']['listed_count']."<br />";               //Số danh sách mà tài khoản hiện tại tồn tại trong dánh sách đó
        // echo "Account Created Date: ". $tweet['user']['created_at']."<br />";   //Ngày tạo tài khoản twitter
        // echo "Favourites Count: ".$tweet['user']['favourites_count']."<br />";  //Số lượt thích/thả tim của người dùng đã tạo ra
        // echo "Statuses Count: ".$tweet['user']['statuses_count']."<br />";      //Số bài tweet người dùng tạo ra(bài tweet thường và retweet)
        // echo "Is Following: ".$tweet['user']['following']."<br />";             //Trạng thái theo dõi của bạn vs người dùng hiện thời
        // echo "<hr>";
    // }
    // echo '<pre>';print_r($tweet);die;
    // echo '<pre>';print_r($tweet_id_array);die;

// $data_tweet = array();
// foreach ($tweet_id_array as $key => $value) {
// 	$url_twweet_id = "https://api.twitter.com/1.1/statuses/show/$value.json";
// 	$single_id = json_decode($twitter->setGetfield($getfield)
// 	->buildOauth($url_twweet_id, $requestMethod)
// 	->performRequest(),$assoc = TRUE);

// 	$data_tweet[] = $single_id;
// }
	// echo '<pre>';print_r($data_tweet);die;

?>

<form method="post" action="littleApp.php">
    <h2>Nhập user</h2> 
    <label for="user1">User 1</label>   
    <input type="text" name="user1" value="<?= isset($user1) ? $user1 :'' ?>">

    <label for="user2">User 2</label> 
    <input type="text" name="user2" value="<?= isset($user2) ? $user2 :'' ?>">

    <label for="user3">User 3</label> 
    <input type="text" name="user3" value="<?= isset($user3) ? $user3 :'' ?>">

    <label for="user4">User 4</label> 
    <input type="text" name="user4" value="<?= isset($user4) ? $user4 :'' ?>">

    <label for="user5">User 5</label> 
    <input type="text" name="user5" value="<?= isset($user5) ? $user5 :'' ?>">

    <button name="btnSubmit">Đánh giá</button>
</form>

<?php if(isset($favorite_array)){ ?>
    <p>ta co ket qua trung binh favorite_count</p>

<?php print_r($favorite_array); } ?>
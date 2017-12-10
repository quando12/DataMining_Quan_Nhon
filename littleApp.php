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
// $url = "https://api.twitter.com/1.1/statuses/show/939162725330051074.json";

$requestMethod = "GET";
if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "nikestore";}
if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 3;}
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$tweet = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);

// echo '<pre>';print_r($tweet);die;

if(!empty($tweet["errors"][0]["message"]))
 {
 	echo "<h3>Sorry, there was a problem.</h3>
 	<p>Twitter returned the following error message:</p><p><em>".$tweet[errors][0]["message"]."</em></p>";
	exit();
}
// echo '<pre>';print_r($tweet);die;	
$tweet_id_array = array();
foreach($tweet as $items)
    {
    	$tweet_id_array[] = $items['id_str'];

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
    }
    // echo '<pre>';print_r($tweet);die;
    // echo '<pre>';print_r($tweet_id_array);die;

$data_tweet = array();
foreach ($tweet_id_array as $key => $value) {
	$url_twweet_id = "https://api.twitter.com/1.1/statuses/show/$value.json";
	$single_id = json_decode($twitter->setGetfield($getfield)
	->buildOauth($url_twweet_id, $requestMethod)
	->performRequest(),$assoc = TRUE);

	$data_tweet[] = $single_id;
}
	echo '<pre>';print_r($data_tweet);die;

?>

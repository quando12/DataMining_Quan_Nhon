<?php
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "845198613663772673-gnHP3ojnRm9WuuJ8Xkj9TP7JSfm8EZV",
'oauth_access_token_secret' => "IPMwtBXWLJpMI7Gk6wFbF829xbdLAEUJYPUAVhR8ZnWKQ",
'consumer_key' => "JdZKWjMwySSl1xgvjADbGlEot",
'consumer_secret' => "qHvmZwJWYeXFfjKJJDLthYuSpV8iLLsOgQvceVu3mN5Led82wz"
);
$url = "https://api.twitter.com/1.1/statuses/home_timeline.json";
// $url = "https://api.twitter.com/1.1/list/list.json?slug=hjph0pdh9x&owner_screen_name=hjph0pdh9x";

$requestMethod = "GET";
if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "hjph0pdh9x";}
if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 10;}
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
echo '<pre>';print_r($string);die;
if(!empty($string["errors"][0]["message"]))
 {
 	echo "<h3>Sorry, there was a problem.</h3>
 	<p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
	exit();
}
foreach($string as $items)
    {
        echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet text: ". $items['text']."<br />";
        echo "id_str: ". $items['user']['id_str']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
?>

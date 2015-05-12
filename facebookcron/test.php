<?php
require('FacebookStatisticBatch.php');
require('FacebookStatisticAgent.php');
require('dbconfig.php');
require('fb/facebook.php');
$filename = 'logs/'.strtotime(date('Y-m-d')).'_facebook_cron.json';
$timeFirst  = date('Y-m-d H:i:s');
if(file_exists($filename)){
	$filegetcontent = file_get_contents($filename);
}
$content['start_time'] = $timeFirst;
$facebook = new Facebook(array(
	'appId'  => '928728477159148',
	'secret' => 'e2dab55acf963b931aedb06443219c1f',
	'cookie' => true,
	'domain' => 'http://www.contentio.no/dashboard'
));
$access_token =  $facebook->getAccessToken();

$statisticObject = new FacebookStatisticAgent;
$facebookIds = getFacebookStatisticBatch();

foreach ($facebookIds as $key => $id) {
	$accountdetail = explode('-',$id);
	$content['account'][$key]['facebook_id'] = $accountdetail[0];
	$content['account'][$key]['facebook_user_id'] = $accountdetail[1];

	$NrOfLikes = $statisticObject->getFacebookNrOfLikes($accountdetail[0],$accountdetail[1],$access_token);
	$content['account'][$key]['stats']['api']['likes'] = $NrOfLikes['api'];
	$content['account'][$key]['stats']['db']['likes'] = $NrOfLikes['db'];
	$content['account'][$key]['stats']['deducted']['like'] = $NrOfLikes['deducted'];
	
	$InsertLikes = $NrOfLikes['deducted'];
	$NrOfPosts = $statisticObject->getFacebookNrOfPosts($accountdetail[0],$accountdetail[1],$access_token);
	$content['account'][$key]['stats']['api']['posts'] = $NrOfPosts['api'];
	$content['account'][$key]['stats']['db']['posts'] = $NrOfPosts['db'];
	$content['account'][$key]['stats']['deducted']['posts'] = $NrOfPosts['deducted'];
	$InsertPosts = $NrOfPosts['deducted'];
	
	$emailcontent .= '<td>'.$facebook_user_id.'</td><td>';
	if($InsertPosts<-1){
		$InsertPosts = 0;
		$emailcontent .= 'Post contain negative value</td>';
		$posterror = 1;
		$content['account'][$key]['stats']['error']['post'] = 'Post contain negative value';
	} 
	$emailcontent .= '</td><td>';
	if($InsertLikes<-1){
		$emailcontent .= 'Like contain negative value</td>';
		$InsertLikes = 0;
		$likeerror = 1;
		$content['account'][$key]['stats']['error']['like'] = 'Like contain negative value';
	}
	$emailcontent .= '</td><tr>';
	$statisticObject->saveFacebookStats($InsertPosts,$InsertLikes,$accountdetail[1]);
}

$timeSecond = date('Y-m-d H:i:s');
$differenceInSeconds = strtotime($timeSecond) - strtotime($timeFirst);
$content['finish_time'] = $timeSecond;
$content['run_time'] = $differenceInSeconds.' Seconds';
$json = json_encode($content);
if(file_exists($filename)){
	$jsonn = rtrim($filegetcontent,']').','.$json.']';
} else {
	$jsonn = '['.$json.']';
}
$f = fopen($filename,'w');
fwrite($f,$jsonn);
if($posterror==1 || $likeerror==1){
	$statisticObject->emailError($emailcontent);
}
?>









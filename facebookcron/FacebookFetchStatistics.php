<?php
 

class FacebookFetchStatistics {
		
	public function getNrOfLikes($pageId,$userId,$accesstoken) {
		$graph_url = "https://graph.facebook.com/".$pageId.'?access_token='.$accesstoken; 
		$page_posts = json_decode(file_get_contents($graph_url), true);
		$nrOfLikes = $page_posts['likes'];
		 $sql = "SELECT SUM(facebook_stats_like) AS totallikes FROM cio_facebook_stats WHERE facebook_user_id = '".$userId."'";
		$conn = mysql_query($sql) or die(mysql_error());
		$fetch = mysql_fetch_object($conn);
		$dbLike = $fetch->totallikes;
		$likeArray['api'] = $nrOfLikes;
		$likeArray['db'] = $dbLike;
		$likeArray['deducted'] = $nrOfLikes-$dbLike;
		//Enter code that gets NrOfLikes for the FacebookPage
		return $likeArray;
	}
	
	public function getNrOfPosts($pageId,$userId,$accesstoken){
		for($i=1; $i<300; $i++){
			
			if($i==1){
				$graph_url = "https://graph.facebook.com/".$pageId."/feed?access_token=".$accesstoken."&limit=250"; 
			} else {
				$graph_url = $nextpage; 
			}
			$page_posts = json_decode(file_get_contents($graph_url), true);
			$nextpage = $page_posts['paging']['next'];
			$content['account'][$whilecount]['pages'][$i] = $nextpage;
			$inext = 'page'.$i;
			if($page_posts==true || !empty($page_posts)){
				$no_of_post += count($page_posts['data']);
			}
			if($nextpage=='' || empty($nextpage)){
				break;
			}
		}
		$sql = "SELECT SUM(facebook_stats_post) AS totalposts FROM cio_facebook_stats WHERE facebook_user_id = '".$userId."'";
		$conn = mysql_query($sql) or die(mysql_error());
		$fetch = mysql_fetch_object($conn);
		$dbPost = $fetch->totalposts;
		$postArray['api'] = $no_of_post;
		$postArray['db'] = $dbPost;
		$postArray['deducted'] = $no_of_post-$dbPost;
		return $postArray;
	}

	public function saveFacebookStats($Posts,$Likes,$userId){
		$sql = "INSERT INTO cio_facebook_stats(facebook_stats_like,facebook_stats_post,facebook_user_id,facebook_stats_add_date) 
		VALUES('".$Likes."','".$Posts."','".$userId."','".date('Y-m-d H:i:s')."')";
		$conn = mysql_query($sql) or die(mysql_error());
		$fetch = mysql_fetch_object($conn);
	
	}
	
	public function emailError($dynemailcontent){
		$emailcontent = '<table width="650" align="left" cellspacing="0" cellpadding="10" border="1" style="font-family:Arial,helvetica,sans-serif; border-collapse:collapse">
					
					<tr>
						<td height="20"><strong>User ID</strong></td>
						<td height="20"><strong>Post Error</strong></td>
						<td height="20"><strong>Like Error</strong></td>
					</tr>
					';
		$emailcontent .= '<tr>';
		$emailcontent .= $dynemailcontent;
		$emailcontent .= '</table>';

		$subject = 'Facebook Cron Error';
		$to = 'wajid@rewterz.com';
		$to2 = 'omar@rewterz.com';
		$message = $emailcontent;
		$url = 'https://api.sendgrid.com/';
		$user = 'Boksiu';
		$pass = 'B)Ksiutx123';
		
		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'to'        => $to,
			'subject'   => $subject,
			'html'      => $message,
			'text'      => '',
			'from'      => 'no-reply@contentio.no'
		);
		$params2 = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'to'        => $to2,
			'subject'   => $subject,
			'html'      => $message,
			'text'      => '',
			'from'      => 'no-reply@contentio.no'
		);
		$request =  $url.'api/mail.send.json';
		$session = curl_init($request);
		curl_setopt ($session, CURLOPT_POST, true);
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params2);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($session);
		curl_close($session);
	
		curl_setopt ($sessionn, CURLOPT_POST, true);
		curl_setopt ($sessionn, CURLOPT_POSTFIELDS, $params);
		curl_setopt($sessionn, CURLOPT_HEADER, false);
		curl_setopt($sessionn, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($sessionn, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($sessionn);
	
		curl_close($sessionn);
	
	}
	

}
 
 
?>
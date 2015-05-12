<?php
 
function getFacebookStatisticBatch() {
	$sql = "SELECT facebook_url_name,facebook_user_id,facebook_url_link FROM cio_facebook_url WHERE facebook_user_id NOT IN('0')";
	$conn = mysql_query($sql) or die(mysql_error());
	while($fetch = mysql_fetch_object($conn)){
		if($fetch->facebook_url_link!=''){
			$facebookIds[] =  $fetch->facebook_url_link.'-'.$fetch->facebook_user_id;
		}
	}

   return $facebookIds;

} 
 
?>
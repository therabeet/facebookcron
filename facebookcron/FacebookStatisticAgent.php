<?php
 
include "FacebookFetchStatistics.php";

class FacebookStatisticAgent extends FacebookFetchStatistics
{

  public function __construct()
  {

  }
  
  public function getFacebookNrOfLikes($pageId,$userId,$accesstoken)
  {
	   $nrOfLikes = $this->getNrOfLikes($pageId,$userId,$accesstoken);
     
     //add code to verify if the datafetch was a sucess or not
     if($nrOfLikes < -1){
      //store the pageid in a "failed table" so we can re-do the datafetching
      return 0;
     } 
    return $nrOfLikes;
     //store the data into the database
     //return "sucess";
    
  }

  public function getFacebookNrOfPosts($pageId,$userId,$accesstoken)
  {
      $nrOfPosts = $this->getNrOfPosts($pageId,$userId,$accesstoken);      
   
     //add code to verify if the datafetch was a sucess or not
     if($nrOfPosts < -1){
      //store the pageid in a "failed table" so we can re-do the datafetching
      return 0;
     } 
     

      //store the data into the database
      return $nrOfPosts;
    
  }

}
 
 
?>
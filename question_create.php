<?php
/* Goal of this program is to 
insert new question into the database.
 */ 
include'functions.php';
if (!isset($_SESSION)){
        session_start();
}
/*if (session_status() == PHP_SESSION_NONE || session_id() == '') {
    session_start();
} Need to check in the future */ 
    
/*ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT); */

$mysqlDB  = connectToFifoDb();
if (is_ajax()) {

  if (isset($_POST["sName"]) && !empty($_POST["sName"])
  && isset($_POST["loc"]) && !empty($_POST["loc"])
  && isset($_POST["question"]) && !empty($_POST["question"]) ){ //Checks if action value exists

  	$sName = $mysqlDB->real_escape_string($_POST["sName"]);
  	$loc = $mysqlDB->real_escape_string($_POST["loc"]);
    
    $topic = $mysqlDB->real_escape_string($_POST["question"]);
      
    $sessionid = $_SESSION["sessionid"];
    
    $query = 'INSERT INTO Question(student, location, topic, Session_idSession) VALUES (?, ?, ?, ?)';
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('ssss', $sName, $loc, $topic, $sessionid);
    
    if($stmt->execute()){
        $return_arr[] = array("success" => "yes",
                              "student" => $sName,
                              "location" => $loc,
                              "topic" => $topic,
                              "sessionid" => $sessionid);
    }else{
        $return_arr[] = array("success" => "no",
                              "student" => $sName,
                              "location" => $loc,
                              "topic" => $topic,
                              "sessionid" => $sessionid);
    }
      
      
   echo json_encode($return_arr);

  }//End of isset

}//End of ajax 


?>

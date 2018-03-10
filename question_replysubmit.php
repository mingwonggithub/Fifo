<?php
/* Goal of this program is to 
update reply of question into the database.
 */ 
include'functions.php';

if (!isset($_SESSION)){
        session_start();
}
if(isset($_POST["qid"]) && !empty($_POST["qid"]) ){
    $qid =$_POST["qid"];
}else{
	$qid = -1; 
}
if(isset($_POST["answer"]) && !empty($_POST["answer"]) ){
    $answer =$_POST["answer"];
}else{
	$answer = ""; 
}
$sessionid = $_SESSION["sessionid"];


$mysqlDB  = connectToFifoDb();
$query = "UPDATE `Question` SET `answer`=? WHERE `idQuestion` = ?";
$stmt = $mysqlDB->prepare($query);
$stmt->bind_param('si', $answer, $qid);

if ($stmt->execute()) { 
	$return_arr[] = array("success" => "yes", "qid"=>$qid,"answer"=>$answer,  "sessionid" => $sessionid); 
	echo json_encode($return_arr);
}
else{
	$return_arr[] = array("success" => "no", "qid"=>$qid,"answer"=>$answer,  "sessionid" => $sessionid); 
     echo json_encode($return_arr);

}

<?php
include'functions.php';
if (!isset($_SESSION)){
        session_start();
 }

if(isset($_POST["qid"]) && !empty($_POST["qid"]) ){
    $qid =$_POST["qid"];
}else{
	$qid = -1; 
}
 
$mysqlDB  = connectToFifoDb();
$query = "SELECT `idQuestion`,`answer` FROM `Question` WHERE `idQuestion` = ?";
$stmt = $mysqlDB->prepare($query);
$stmt->bind_param('i',  $qid);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($qid, $answer);

if ($stmt->num_rows == 1) { 
    $stmt->fetch();
	$return_arr[] = array("success" => "yes", "qid"=>$qid,"answer"=>$answer); 
	echo json_encode($return_arr);

}
else{
	$return_arr[] = array("success" => "no", "qid"=>$qid,"answer"=>$answer); 
     echo json_encode($return_arr);

}


?>

<?php
/* Goal of this program is to create
a new session into the database */ 
include'functions.php';
    if (!isset($_SESSION)){
        session_start();
    }

//Todo: Need to invest of this error reporting later 
/*ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);*/

$mysqlDB  = connectToFifoDb();

if (isset($_POST["subject"]) && !empty($_POST["subject"])
  && isset($_POST["courseN"]) && !empty($_POST["courseN"]) 
  && isset($_POST["room"]) && !empty($_POST["room"])){
    
    $class = $mysqlDB->real_escape_string(strtoupper($_POST["subject"])) . $mysqlDB->real_escape_string(strtoupper($_POST["courseN"]));
    $room = $mysqlDB->real_escape_string(strtoupper($_POST["room"]));
    $startTime = date("Y-m-d H:i:s");
    $userid = $_SESSION["userid"];

    $query = 'INSERT INTO Session(class, room, startTime, Instructor_idInstructor) VALUES (?, ?, ? ,?)';
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('sssi', $class, $room, $startTime, $userid);
    
    if($stmt->execute()){
        echo "success";
    }else{
        echo "failure";
    }

}

?>
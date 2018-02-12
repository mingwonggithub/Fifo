<?php
/* Goal of this program is to delete
question from the database */ 
    include'functions.php';

    if (!isset($_SESSION)){
        session_start();
    }
    $mysqlDB  = connectToFifoDb();
    $sessionid =
    $qid = $_POST["qid"];
    $sessionid = $_SESSION["sessionid"];

    $query = "DELETE FROM `Question` WHERE `Question`.`idQuestion` = ?";
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('i', $qid);
    
    if($stmt->execute()){
        $return_arr[] = array("success" => "yes",
                              "qid" => $qid,
                              "sessionid" => $sessionid);
    }else{
        $return_arr[] = array("success" => "yes",
                              "qid" => $qid,
                              "sessionid" => $sessionid);
    }
    
    echo json_encode($return_arr);

    ?>

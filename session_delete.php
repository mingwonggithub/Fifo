<?php
/* Goal of this program is to delete
the session based on the idSession and
idInstructor */ 
    include'functions.php';

    if (!isset($_SESSION)){
        session_start();
    }
    $mysqlDB  = connectToFifoDb();
    
    $sessionid = $_POST["sessionid"];
    $userid =  $_SESSION["userid"];
    $query = "DELETE FROM `Session` WHERE `Session`.`idSession` = ? AND `Session`.`Instructor_idInstructor` = ?";
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('ii', $sessionid, $userid);
    
    if($stmt->execute()){
        echo "success";
    }else{
        echo "failure";
    }

    ?>

<?php
/* Goal of this program is to populate the 
Sessions table for Session.html*/ 

    include'functions.php';
    if (!isset($_SESSION)){
        session_start();
    }
    
    if(isset($_POST["userid"]) && !empty($_POST["userid"]) ){
       $_SESSION["userid"] =$_POST["userid"];
    }
    if(isset($_POST["user"]) && !empty($_POST["user"]) ){
        $_SESSION["user"] =$_POST["user"];
    }
    $mysqlDB  = connectToFifoDb();
    $query = "SELECT `idSession`,`class`,`room`,`startTime` FROM `Session` WHERE `Instructor_idInstructor` = ?";
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('i',  $_SESSION["userid"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sessionid, $class, $room, $startTime);
    
    $str = "";
    while($stmt->fetch())
    {
        $str = $str . "<tr>"
        ."<td id='sess'><a id='". $sessionid ."'" . ">". $sessionid . "</a> </td> "
        ."<td>" . $startTime . "</td>"
        ."<td>" . $class . "</td>"
        ."<td>" . $room . "</td>"
        . "<td>"
        ."<div class='control'><label class='radio'><input type='radio' name='answer' value='". $sessionid . "'> Remove</label></div>"
        . "</td>"
        . "</tr>"
        . "
        ";
    }

    $html = file_get_contents("Session.html"); // opens template.html
    $html = str_replace('{{name}}', $_SESSION['user'], $html); // replaces placeholder with $username
    $html = str_replace('{{content}}', $str, $html);
    echo $html;
    
    ?>
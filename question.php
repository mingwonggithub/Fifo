<?php
/* Goal of this program is to populate
question list on Question.html */ 
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
    if(isset($_POST["sessionid"]) && !empty($_POST["sessionid"]) ){
        $sessionid =$_POST["sessionid"];
        $_SESSION["sessionid"] =$_POST["sessionid"];
    }
    
    $mysqlDB  = connectToFifoDb();
    $query = "SELECT `class` FROM `Session` WHERE `idSession` = ?";
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('i',  $sessionid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($class);
    $stmt->fetch();
    
    $query = "SELECT `idQuestion`, `student`,`location`, `topic` FROM `Question` WHERE `Session_idSession` = ?";
    $stmt = $mysqlDB->prepare($query);
    $stmt->bind_param('i',  $sessionid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($qid, $student, $loc, $topic);

    $str = ""; 
    while($stmt->fetch())
    {
        $str = $str . "<div class='box level'><div class='tile is-ancestor'><div class='tile is-2'>"
        . $student
        ."<br>"
        .$loc
        ."</div><div class='tile is-9'>"
        .$topic
        ."</div><div class='tile is-1'><a id='"
        .$qid
        . "'class='button question'><span class='icon is-medium is-info'><i class='fas fa-trash'></i></span></a></div></div></div>";
        
    }

    $html = file_get_contents("Question.html"); // opens template.html
    $html = str_replace('{{className}}', $class, $html); // replaces placeholder with $classname
    $html = str_replace('{{content}}', $str, $html);
    echo $html;
    
    ?>
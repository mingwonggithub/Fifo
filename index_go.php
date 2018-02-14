<?php
/* Goal of this program is to populate 
the question list when entering from the
landing page */
 
include'functions.php';
$mysqlDB  = connectToFifoDb();
if (is_ajax()) {
 $_POST = array_map("trim", $_POST);

  if (isset($_POST["subject"]) && !empty($_POST["subject"])
  && isset($_POST["courseN"]) && !empty($_POST["courseN"])
  && isset($_POST["room"]) && !empty($_POST["room"])

      ){ //Checks if action value exists

    $class = $mysqlDB->real_escape_string(strtoupper($_POST["subject"])) . $mysqlDB->real_escape_string(strtoupper($_POST["courseN"]));
    $room = $mysqlDB->real_escape_string(strtoupper($_POST["room"]));

  	$query = "SELECT `idSession` FROM `Session` WHERE `class`=? and `room`=? ORDER by `startTime` DESC LIMIT 1 ";
  	$stmt = $mysqlDB->prepare($query);
  	$stmt->bind_param('ss', $class, $room);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);

    if ($stmt->num_rows == 1) { 
      $stmt->fetch();
      $return_arr[] = array("success" => "yes",
      				"sessionid" => $id,
                    "class" => $class,
                    "room" => $room);

      echo json_encode($return_arr);

    }else{
        $return_arr[] = array("success" => "no",
                              "sessionid" => $id,
                              "class" => $class,
                              "room" => $room);

      echo json_encode($return_arr);

    }

  }// End of isset 

}// End of is_ajax

?> 
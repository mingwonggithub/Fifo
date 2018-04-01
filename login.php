<?php
/* Goal of this program is to 
perform login of instructors */ 

include'functions.php';
$mysqlDB  = connectToFifoDb();
if (is_ajax()) {

  if (isset($_POST["l_uname"]) && !empty($_POST["l_uname"]) 
  && isset($_POST["l_password"]) && !empty($_POST["l_password"]) ){ //Checks if action value exists

	  $uname = $mysqlDB->real_escape_string($_POST["l_uname"]);
  	$password = $mysqlDB->real_escape_string($_POST["l_password"]);

  	$query = "SELECT idInstructor FROM Instructor WHERE username=? and password=?"; 
  	$stmt = $mysqlDB->prepare($query);
  	$stmt->bind_param('ss', $uname, $password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);

    if ($stmt->num_rows == 1) { 
      $stmt->fetch();
      $return_arr[] = array("success" => "yes",
      				"userid" => $id, 
                    "uname" => $uname,
                    "password" => $password);

      echo json_encode($return_arr);

    }else{
      $return_arr[] = array("success" => "no",
      	      		"userid" => $id, 
                    "uname" => $uname,
                    "password" => $password);

      echo json_encode($return_arr);

    }

  }// End of isset 

}// End of is_ajax

?> 

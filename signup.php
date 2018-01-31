<?php
/* Goal of this program is to register
new users into the database. Check if there
is existing users */ 

include'functions.php';

$mysqlDB  = connectToFifoDb();

if (is_ajax()) {

  if (isset($_POST["uname"]) && !empty($_POST["uname"]) 
  && isset($_POST["password"]) && !empty($_POST["password"]) ){ //Checks if action value exists

  	$uname = $mysqlDB->real_escape_string($_POST["uname"]);
  	$password = $mysqlDB->real_escape_string($_POST["password"]);

  	$query = "SELECT username FROM Instructor WHERE username=?"; 
  	$stmt = $mysqlDB->prepare($query);
  	$stmt->bind_param('s', $uname);
    $stmt->execute();
    $stmt->store_result();
 

    if ($stmt->num_rows == 0) { 
      $query = 'INSERT INTO Instructor(username, password) VALUES (?, ?)';
      $stmt = $mysqlDB->prepare($query);
      $stmt->bind_param('ss', $uname, $password);
      $stmt->execute();

      $return_arr[] = array("success" => "yes",
                    "uname" => $uname,
                    "password" => $password);

      echo json_encode($return_arr);

    } else{
      
      $return_arr[] = array("success" => "no",
                    "uname" => $uname,
                    "password" => $password);
       echo json_encode($return_arr);

    } //End of if(stm->num_rows)


  }//End of isset

}//End of ajax 

?>
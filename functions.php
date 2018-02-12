<?
/* List of common functions to use by all html files */ 

//Function to connect to database
function connectToFifoDb(){
	//note putting db info outside of sites is for secure reason
    $config = parse_ini_file('../fifodb.ini'); 
    $conn = new mysqli($config['host'],$config['username'],$config['password'],$config['database']);
    if ($conn->connect_error) {
    	die("Connection to wishing database failed: " . $conn->connect_error);
	}
    $conn->set_charset("utf8");
    return $conn;
}

//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

//Function to begin session
function begin_Session(){
    session_start();
}

?>

<?php
  
  
  include $_SERVER['DOCUMENT_ROOT'].'/include/log.inc.php';

  // action = login
  // login user with $_POST['username'] & $_POST['password'] information
  // sets $_SESSION variable ['user']
  // return JSON array object { loggedin, error, firstname }
  if (isset($_POST['action']) && $_POST['action'] == 'login' ){
    // checks current session status
    if (!status()){

      if (empty($_POST['username']) || empty($_POST['password'])) {
              $login_error = "Username or Password is invalid";
              append_log($login_error);
              header('Content-Type: application/json');
              echo json_encode( array( 'success' => 'false', 'error' => $login_error) );
          }
          else {
              // Define $username and $password
              $username = $_POST['username'];
              $password = $_POST['password'];
                         
              include $_SERVER['DOCUMENT_ROOT'].'/include/connect.inc.php';
              
              // Protect from mySQL injection for security
              $username = stripcslashes($username);
              $password = stripcslashes($password);
              
              // start session
              session_start();
              try {
                  // Open database connection
                  $pdo = dbConnect();
                  $sql = 'SELECT COUNT(*) AS "count" FROM tbUser
                          WHERE username = :username
                          AND password = MD5(CONCAT(:password,"mickey mouse"))';
                  $s = $pdo -> prepare($sql);
                  $s -> bindParam(':password', $password, PDO::PARAM_STR);
                  $s -> bindParam(':username', $username);
                  $s -> execute();
  
                  $res =$s -> fetch(PDO::FETCH_BOTH);
  
                  if ( $res[0] == 1 ) {
                      $_SESSION['user'] = $username; // Initialize Session
                      append_log($username.' logged in successfully');
                      header('Content-Type: application/json');
                      echo json_encode( array( 'success' => 'true', 'error' => '') );
                  }
                  else {
                      $login_error = "Username or Password is invalid";
                      header('Content-Type: application/json');
                      echo json_encode( array ('success' => 'false', 'error' => $login_error) );
                  }
              }
              catch (PDOException $e) {
                header('Content-Type: application/json');
                echo json_encode( array( 'success' => 'false', 'error' => $e->getMessage()) );
              }
          }
    }
  }

  // action = logout
  // log current session user out clear $_SESSION array and destroy
  if (isset($_POST['action']) && $_POST['action'] == 'logout' ) {
    
  }

  // action = status
  // return true if $_SESSION user is currently logged in
  // returns false is no $_SESSION information is available
  if (isset($_GET['action']) && $_GET['action'] == 'status' ) {
    if (status()) {
      echo json_encode( array('loggedin'=>'true', 'error'=>'', 'firstname'=>$_SESSION['user']) );
    }
    else {
      echo json_encode( array('loggedin'=>'false', 'error'=>'No active session', 'firstname'=>'') );
    }
  }
  
  // returns true if session is active
  function status() {
    // PHP_SESSION_ACTIVE if sessions are enabled, and one exists.  
    if (session_status() == PHP_SESSION_ACTIVE) {
      return true;
    }
    // PHP_SESSION_DISABLED if sessions are disabled.
    // PHP_SESSION_NONE if sessions are enabled, but none exists.
    else {
      return false;
    }
  }
  
?>

  <!--class Access {
    
    private $loggedIn = false;
    private $firstName;
    private $error;
    
    public function _construct($username, $password){
      if ($loggedIn == true)
        logout();
        login($username, $password);
    }
    
    public function error(){
      echo $error;  
    }
    
    public function login($username, $password) {
      
    }
    
    public function logout() {
      
    }
  
  }-->
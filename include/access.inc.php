<?php
/*
 * access.inc.php tests username and password validity and 
 * returns JSON object { action, authorized, message, session, name }
 * 
 * action is the activity that was being undertaken
 * authorized is a boolean state allowing the object to be accessed or not
 * message is the output string highlightin the outcome
 * session is the PHPSESSID
 * name is the person who has been granted access
*/
  
  // not making this mistake again! json objects are hard to decipher in js when the object type isn't declared
  header('Content-Type: application/json');
  
  include $_SERVER['DOCUMENT_ROOT'].'/include/log.inc.php';

/*
 * action = login
 * login user with $_POST['username'] & $_POST['password'] information
 * sets $_SESSION variable ['user']
 * return JSON array object { loggedin, error, name }
*/
  if (isset($_POST['action']) && $_POST['action'] == 'login' ){
    // checks current session status
    if ( !status() ) {
      // validate the username and password data sent from the server
      if (empty($_POST['username']) || empty($_POST['password'])) {
        $login_error = "Username or Password is empty.";
        header('Content-Type: application/json');
        echo json_encode( array( 'action'=>'login', 'authorized' => false, 'message' => $login_error) );
      }
      else {
        // Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
                   
        include $_SERVER['DOCUMENT_ROOT'].'/include/connect.inc.php';
        
        // Protect from mySQL injection for security
        $username = stripcslashes($username);
        $password = stripcslashes($password);
        
        // start session and set $_SESSION['id'] variable
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
            $_SESSION['id'] = session_id(); // Initialize $_SESSION variable
            $sql = 'SELECT fname FROM tbUser
                  WHERE username = :username
                  AND password = MD5(CONCAT(:password,"mickey mouse"))';
            $s = $pdo -> prepare($sql);
            $s -> bindParam(':password', $password, PDO::PARAM_STR);
            $s -> bindParam(':username', $username);
            $s -> execute();
            $row = $s->fetch(PDO::FETCH_BOTH); // fetch the first row of results (there should be only one)
            $_SESSION['username'] = $username; // Initialize $_SESSION variable
            $_SESSION['name'] = $row['fname'];
            
            append_log($username.' logged in successfully');
            echo json_encode( array( 'action'=>'login', 'authorized' => true, 'message' => 'login successful',
                                      'session'=>$_SESSION['id'], 'name' => $_SESSION['name']) );
          }
          else {
              $login_error = "Username or Password is invalid";
              header('Content-Type: application/json');
              echo json_encode( array ( 'action'=>'login', 'authorized' => false, 'message' => $login_error) );
          }
        }
        catch (PDOException $e) {
          header('Content-Type: application/json');
          echo json_encode( array( 'action'=>'login', 'authorized' => false, 'message' => $e->getMessage()) );
        }
      }
    }
  }
  
/*
 * action = logout
 * log current session user out clear $_SESSION array and destroy
*/
  if (isset($_POST['action']) && $_POST['action'] == 'logout' ) {
    // Unset all of the session variables.
    $_SESSION = array();
    
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      // Expire the session cookie and 
      setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
    }
    // Finally, destroy the session.
    session_destroy();
    
    echo json_encode( array( 'action'=>'logout', 'authorized' => false, 'message' => 'Logout successful.' ) );
  }

/*
 * action = status
 * return true if $_SESSION user is currently logged in
 * returns false is no $_SESSION information is available
*/
  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'status' ) {
    session_start();
    if (status()) {
      echo json_encode( array( 'action' => 'status', 'authorized'=> true, 'message' => 'Session active.',
                                'session' => $_SESSION['id'], 'name'=>$_SESSION['name']) );
    }
    else {
      echo json_encode( array( 'action' => 'status', 'authorized' => false, 'message' => 'No active session',
                                'name' => '' ) );
    }
  }
  
// returns true if session is active
  function status() {
    return isset($_SESSION['id']); 
  }
  
?>
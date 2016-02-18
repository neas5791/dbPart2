<?php
// http://www.formget.com/login-form-in-php/
// login object functions return
//      {
//          success: (true/false)
//          error: (message)
//          isLogged: (true/false)
//      }


    session_start(); // start session
    include $_SERVER['DOCUMENT_ROOT'].'/include/log.inc.php';
    $login_error=''; // somewhere to keep our error messages
    
    if (isset($_POST['action']) && $_POST['action'] == 'login'){
        
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
    else if (isset($_GET['action']) && $_GET['action'] == 'logout'){
        append_log($_SESSION['user'].' has logged out');
        $_SESSION = array();
        session_destroy();
        echo json_encode(array('success'=> 'true', 'error'=>''));
    }
?>
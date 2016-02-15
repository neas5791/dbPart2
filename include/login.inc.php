<?php
//http://www.formget.com/login-form-in-php/
    session_start(); // start session
    include $_SERVER['DOCUMENT_ROOT'].'/include/log.inc.php';
    $login_error=''; // somewhere to keep our error messages
    
    if (isset($_POST['submit'])){
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $login_error = "Username or Password is invalid";
            append_log($login_error);
        }
        else {
            // Define $username and $password
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            include $_SERVER['DOCUMENT_ROOT'].'/include/connect.inc.php';
            
            // Protect from mySQL injection for security
            $username = stripcslashes($username);
            $password = stripcslashes($password);
            $username = mysqli_real_escape_string($username);
            $password = mysqli_real_escape_string($password);
            
            $hashed_password = hash('md5', $password.'mickey mouse');
            
            try {
                // Open database connection
                $pdo = dbConnect();
                $sql = 'SELECT COUNT(*) FROM tbUSER
                        WHERE
                            password = :password
                        AND
                            username = :username';
                $s = $pdo -> prepare($sql);
                $s -> bindValue(':password', $hash_password, PDO::PARAM_STR);
                $s -> bindValue(':username', $username, PDO::PARAM_STR);
                $s -> execute();
                
                if ( $s -> fetchColumn() == 1 ) {
                    $_SESSION['login_user'] = $username; // Initialize Session
                    append_log($username.' logged in successfully');
                }
                else {
                    $login_error = "Username or Password is invalid";
                }
            }
            catch (PDOException $e) {
                
            }
        }
    }
?>
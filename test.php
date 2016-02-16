<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
    
    include $_SERVER['DOCUMENT_ROOT'].'/include/log.inc.php';
    include $_SERVER['DOCUMENT_ROOT'].'/include/connect.inc.php';

    $username = 'sean';
    $password = 'password';
            //  '0a940424f7bd015f023485d31912e58e';
    
    $hashed_password = hash('md5', $password.'mickey mouse');
    
    try {
        // Open database connection
        $pdo = dbConnect();
        $sql = 'SELECT COUNT(*) AS "count" FROM tbUser
                WHERE username = :username
                AND password = MD5(CONCAT(:password,"mickey mouse"))';
        $s = $pdo -> prepare($sql);
        $s -> bindParam(':username', $username);
        $s -> bindParam(':password', $password, PDO::PARAM_STR);
        $s -> execute();
        
        echo $username." - ".$hashed_password."/n";
        $res =$s -> fetch(PDO::FETCH_BOTH);
        echo $res[0];
        print_r( $res);
        if ( $res[0] == 1 ) {
            //$_SESSION['login_user'] = $username; // Initialize Session
            //append_log($username.' logged in successfully');
            echo json_encode( (object) [ 'success' => 'true', 'error' => ''] );
        }
        else {
            $login_error = "Username or Password is invalid";
            echo json_encode( (object) [ 'success' => 'false', 'error' => $login_error] );
        }
        
        
    }
    catch(PDOException $e){
        echo $e->getMessage();     
    }
?>

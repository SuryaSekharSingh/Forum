<?php
    $showError = "false";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        include '_dbconnect.php';
        $email = $_POST['loginEmail'];
        $pass = $_POST['loginPass'];
        // $username;
        // for($i = 0; $i < strlen($email); ++$i){
        //     if($email[$i] != '@'){
        //         $username += $email[$i];
        //         continue;
        //     }
        //     else
        //         break;
        // }
        $sql = "select * from users where user_email='$email'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if($numRows == 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row['user_pass'])){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $email;
                $_SESSION['user_id'] = $row['user_id']; 
                // $_SESSION['username'] = $username;
                // echo "Logged in $email";
                header("location: /forum/index.php");
                exit();
            }
            $showError = "Password mismatch";
        }
        else 
            $showError = "Wrong Credentials";
            // if($showError != "false"){
            //     echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            //     <strong>Failed!</strong>' . $showError . '
            //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            //     </div>';
            // }
        header("location: /forum/index.php?error=$showError");
    }
?>
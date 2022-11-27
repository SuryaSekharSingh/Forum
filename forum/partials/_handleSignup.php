<?php
    $showError = "false";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        include '_dbconnect.php';
        $user_email = $_POST['signupEmail'];
        $pass = $_POST['signuppassword'];
        $cpass = $_POST['signupcpassword'];

        //check whether this email already exists in the database or not 
        // duplicate email entries would be fatal for the company
        $existSql = "select * from users where user_email='$user_email'";
        $result = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($result);
        if($numRows > 0){
            $showError = "Email already in use";
        // header("location: /forum/index.php?signupsuccess=false&error=$showError");
        }
        else{
            if($pass == $cpass){
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "insert into users (user_email, user_pass, timestamp) 
                values ('$user_email', '$hash', 'current_timestamp()')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $showAlert = true;
                    header("location: /forum/index.php?signupsuccess=true");
                    exit();
                }
            }
            else{
                $showError = "Passwords do not match";
            }
        }
        header("location: /forum/index.php?signupsuccess=false&error=$showError");
    }

?>
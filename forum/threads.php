<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome to colliDEA - Where ideas collide</title>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <?php
        $id = $_GET['threadid'];
        $sql = "select * from threads where thread_id = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];

            // Query the users table to find out the Original Poster.
            $sql2 = "select * from users where user_id='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
        }   
    
    ?>

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        $showAlert = false;
        if($method == 'POST'){
            //  insert into comments db
            $comment =  $_POST['comment'];
            $user_id = $_SESSION['user_id'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);
            $sql = "insert into comments (comment_content, thread_id, comment_by, comment_time) 
            values('$comment', '$id', '$user_id', 'current_timestamp()');";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo '  <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your comment has been added.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                ';
            }

        }
    ?>

    <!-- category container starts here  -->

    <div class="container my-2">
        <div class="jumbotron" style="background-color:#E0FFFF">
            <h1 class="display-4 mx-2"><?php echo $title;?></h1>
            <p class="lead mx-2"><?php echo $desc;?>
            </p>
            <hr class="my-4">
            <p class="mx-2">This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not
                allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <p class="mx-2">Posted by : <em><?php  echo $posted_by;  ?></em></p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true"){

        echo '<div class="container my-3">
        <h1 class="py-2">Post a Comment</h1>
        <form action="' . $_SERVER['REQUEST_URI'] . '." method="post">
        
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <!-- <imput type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '"></imput> -->
            </div>
            <button type="submit" class="btn btn-success ">Post Comment</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <p class="lead">You are not logged in. Please login to start a discussion.</p>
            </div>';
    }

    ?>
    <div class="container">
        <h1 class="py-2">Discussions</h1>

        <?php
            $id = $_GET['threadid'];
            $sql = "select * from comments where thread_id = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $id = $row['comment_id'];
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $thread_user_id = $row['comment_by'];
                $sql2 = "select user_email from users where user_id='$thread_user_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $user_email = $row2['user_email'];

                // echo '<div class="media my-4">
                // <span>
                //     <img src="img/userdefault.png" height="65px" width="80px" class="mr-3" alt="...">
                // </span>
                // <div class="flex-grow-1 ms-3">
                // <p class="font-weight-bold my-0">Anonymous User</p>' . $content . '
                // </div>';
                echo   '<div class="media my-3 pb-4">
                            <div class="media-body">
                                <img src="img/userdefault.png" width="54px" class="mr-3" alt="..."><b><i>'. $user_email .' at '. $comment_time .'</i></b>
                                <p class="font-weight-bold my-0 mx-5 px-1">' . $content . '</p> 
                            </div>
                        </div>';

            }   
            if($noResult){
                // echo var_dump($noResult);
               echo '<div  class="jumbotron jumbotron-fluid pb-4" style="background-color:#E0FFFF">
                    <div class="container my-2 mx-2">
                        <p class="display-4">No Comments Found</p>
                        <p class="lead">Be the first person to answer the question</p>
                    </div>
                </div>';
            }
        ?>
    </div>


        <?php include 'partials/_footer.php';?>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>
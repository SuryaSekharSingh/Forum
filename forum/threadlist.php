<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title><?php  
                include 'partials/_dbconnect.php';
                $id = $_GET['catid'];
                $sql = "select * from categories where category_id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo "Welcome to " . $row['category_name'] . " Forums";
            ?></title>
    <style>
        .hove:hover{
            color:red !important;
        }
    </style>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <?php
        $id = $_GET['catid'];
        $sql = "select * from categories where category_id = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }   
    
    ?>

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        //  echo $method; 
        $showAlert = false;
        if($method == 'POST'){
            //  insert into thread into db
            $th_title =  $_POST['title'];
            $th_desc = $_POST['desc'];
            $user_id = $_POST['user_id'];
            $th_title = str_replace("<","&lt;", $th_title);
            $th_title = str_replace(">","&gt;", $th_title);
            $th_desc = str_replace("<","&lt;", $th_desc);
            $th_desc = str_replace(">","&gt;", $th_desc);
            $sql = "insert into threads (thread_title, thread_desc, thread_cat_id, thread_user_id, timestamp) 
            values('$th_title', '$th_desc', '$id', '$user_id', 'current_timestamp()')";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo '  <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your thread has been added. Wait for the community to respond.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                ';
            }

        }
    ?>

    <!-- category container starts here  -->
    <div style="height:100%;">
    <div class="container my-2">
        <div class="jumbotron pb-3" style="background-color:#E0FFFF">
            <h1 class="display-4 mx-2">Welcome to <?php echo $catname;?> Forums</h1>
            <p class="lead mx-2"><?php echo $catdesc;?>
            </p>
            <hr class="my-4">
            <p class=mx-2>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not
                allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg mx-2 " href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true"){

        echo '<div class="container my-3">
            <h1 class="py-2">Start a Discussion</h1>
            <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Problem title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible</div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Elaborate your concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '"></input>       

                <button type="submit" class="btn btn-success ">Submit</button>
            </form>
        </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
            <p class="lead">You are not logged in. Please login to start a discussion.</p>
            </div>';
    }

    ?>
    
    <div class="container">
        <h1 class="py-2">Browse Questions</h1>

        <?php
            $id = $_GET['catid'];
            $sql = "select * from threads where thread_cat_id = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $sql2 = "select user_email from users where user_id = '$thread_user_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row = mysqli_fetch_assoc($result2);
                $user_email = $row['user_email'];

                echo '<div class="d-flex " style="margin-bottom:40px;">
                <div class="flex-shrink-0">
                    <img src="img/userdefault.png" width="54px" class="mr-3" alt="...">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mt-0"><a href="threads.php?threadid=' . $id . '" class="text-dark hove" style="text-decoration:none;">' . $title . '</a></h5>' .
                    $desc . '</div>
                    <div class="font-weight-bold my-0">Asked by: <b><i>' . $user_email . '</i> at ' . $thread_time . '</b></div> 
                </div>';
            }   
            if($noResult){
                // echo var_dump($noResult);
               echo '<div  class="jumbotron jumbotron-fluid pb-4" style="background-color:#E0FFFF">
                    <div class="container my-2 mx-2">
                        <p class="display-4">No Threads Found</p>
                        <p class="lead">Be the first person to ask a question</p>
                    </div>
                </div>';
            }
        ?>

        </div>
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
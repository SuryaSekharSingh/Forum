<?php
session_start();
// if(isset($_SESSION['username']))
//     echo "yes";
// else
//     echo "no";
echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">colliDEA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/forum/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/forum/about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Categories</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/forum/contact.php" class="nav-link">Contact</a>
                </li>
                </ul>';
        //      <div class="row mx-2">
        //         <form class="form-inline my-2 my-lg-0" role="search">
        //         <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        //         <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        //         <button class="btn btn-outline-success ml-2">Login</button>
        //         <button class="btn btn-outline-success mx-2">Signup</button>
        //         </form>
        //     </div> 
        //   <div class="container"> 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<form class="d-flex" role="search">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" style="width:200px;">
                    <button class="btn btn-success mx-2" type="submit" style="border-radius:20px;">Search</button>
                    <p class="text-light my-0 pt-1">Welcome ' . $_SESSION['username'] . '</p>
                </form>
            <a href="partials/_logout.php" role="button"class="btn btn-outline-success mx-2" style="border-radius:20px;">Logout</a>';
}
else{
    echo '<form class="d-flex" role="search">
    <input class="form-control mx-2" type="search" placeholder="Search" aria-label="Search" style="width:200px;">
    <button class="btn btn-success" type="submit" style="border-radius:20px;">Search</button>
    </form>
    <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginModal" style="border-radius:20px;">Login</button>
    <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#signupModal" style="border-radius:20px;">Signup</button>
    <!-- </div> -->';
}
            
    echo'  </div>
    </div>
</nav>
';
require 'partials/_loginModal.php';
require 'partials/_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
    echo '
        <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login using your username and password
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
else if(isset($_GET['error']) && $_GET['error'] != "false"){
    echo '  <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Warning!</strong> ' . $_GET['error'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
?>
<?php
    session_start();
    // session_unset();
    session_destroy();
    echo "Logging you out. Please wait.....";
    header("location: /forum/index.php?logout=true");

?>
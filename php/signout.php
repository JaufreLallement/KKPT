<?php
    session_start(); // Get session global variable
    session_destroy(); // Destroy the current session
    header("Location: /KKPT/index.php"); // Return to the index
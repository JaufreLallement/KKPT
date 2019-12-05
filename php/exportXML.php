<?php

    // Required content
    require_once '../inc/root.include.php';
    require_once ROOT.'class/User.class.php';

    session_start(); // Get session global variable

    if (isset($_POST['savedXML'])) {
        // If admin connected, we want to save the whole database
        if (isset($_SESSION['user'])) {
            $fileName = 'database.xml'; // default name of the file
            $data = $_SESSION['xml'];
        } else {
            $user = $_SESSION['xml'];
            $fileName = strtolower($user['firstname']."_".$user['name'].'.xml'); // default name of the file
            $data = array('0' => $user);
        }
        
        $saved = User::exportXML($fileName, $data); // Save as XML file
    }
    exit;
?>
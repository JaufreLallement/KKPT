<?php
    // Required content
    require_once '../inc/root.include.php';
    require_once ROOT.'class/User.class.php';

    session_start(); // Get session global variable

    if (isset($_POST['deleteUser'])) {
        $res = User::deleteUser($_POST['deleteUser']); // Delete the user corresponding to the given id
        
        if ($res['status'] === "success") $data = User::getUserList(); // Get the up to date userlist
        else $data = null; // Handle error

        $final = array('status' => $res['status'], 'msg' => $res['msg'], 'data' => $data); // Build final array to send
        echo json_encode($final); // Returning the data
    }

    exit;
?>
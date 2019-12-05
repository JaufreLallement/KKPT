<?php

    // Required content
    require_once 'inc/root.include.php';
    require_once ROOT.'class/Webpage.class.php';
    require_once ROOT.'class/User.class.php';

    session_start(); // Get session global variable

    $p = new Webpage('KKPT'); // Initialisation of the page

    // Check if the user is connected
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user']->getEmail(); // Retreive the username (email address)
        $panel = User::getAdminPanel($username); // Get the admin panel for the given user
        $p->appendContent($panel); // Append the panel to the content of the page
    } else {
        $signup = User::getSignupForm(); // Get the signup form
        $p->appendContent($signup); // Append the form to the content of the webpage
    }

    echo $p->toHtml(); // Display the webpage
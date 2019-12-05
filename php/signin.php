<?php

    // Required content
    require_once '../inc/root.include.php';
    require_once ROOT.'class/Webpage.class.php';
    require_once ROOT.'class/User.class.php';

    session_start(); // Get session global variable

    $p = new Webpage('KKPT'); // Creating new webpage

    // HTML content for the sign in form
    $content = <<<HTML
        <article id="iwa1-summary-article">
            <h2 class="title article-title signin-form-title">Sign in as Administrator</h2>
            <form id="signin-form" class="classic-form" method="post">
                <div class="signin-inputs">
                    <div class="input-wrapper">
                        <label for="username" class="block-label" required="true">Username (email address): </label>
                        <input type="mail" id="signin-username" name="username" placeholder="Login" class="lined-input text-input login-input" required>
                    </div>
                    <div class="input-wrapper">
                        <label for="password" class="block-label" required="true">Password: </label>
                        <input type="password" id="signin-password" name="password" placeholder="Password" class="lined-input text-input login-input" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="form-button">Sign in</button>
                </div>
            </form>
        </article>
HTML;

    // Check if the signin for has been submited
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $user = User::signin($_POST['username'], $_POST['password']); // Execute the signin method to get the instance of user

        // Check if the result is an instance of the class User
        if ($user instanceof User) {
            $_SESSION['user'] = $user; // Set the session variable
            header('Location: /KKPT/index.php'); // Redirection
        } else {
            $p->appendContent($content); // Append the form to the webpage content
            $_SESSION['signin_attempt'] = "Error: {$user}"; // Error occured
        }
    } else {
        $p->appendContent($content); // Append the form to the webpage content

        // Check if an attempt was made and if there was an error
        if (isset($_SESSION['signin_attempt'])) {
            $p->appendContent(<<<HTML
                <p class="error-line">{$_SESSION['signin_attempt']}</p>
HTML
            );
        }
    }
    
    echo $p->toHtml(); // Display the webpage
    exit;
?>
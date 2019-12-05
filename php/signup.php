<?php

    // Required content
    require_once '../inc/root.include.php';
    require_once ROOT.'class/Webpage.class.php';
    require_once ROOT.'class/User.class.php';

    session_start(); // Get session global variable

    $p = new Webpage('KKPT'); // New Webpage
    $summary = ''; // Initialise summary variable

    // Check if the POST variable is set and contains enough data
    if (isset($_POST['name'])
        && isset($_POST['firstname'])
        && isset($_POST['city'])
        && isset($_POST['birthdate'])
        && isset($_POST['email'])
        && isset($_POST['passwd'])
        && isset($_POST['gender'])
        && isset($_POST['studyprog'])
        && isset($_POST['language'])) {

        // Password verification
        $password = $_POST['passwd'];

        if (User::checkPasswdFormat($password)) {

            // Further verifications
            $noNumber = !preg_match('@[0-9]@', $_POST['name']) && !preg_match('@[0-9]@', $_POST['firstname']) && !preg_match('@[0-9]@', $_POST['city']);

            if ($noNumber) {
                // Data from the form
                $data = array(
                    'name' => $_POST['name'],
                    'firstname' => $_POST['firstname'],
                    'city' => $_POST['city'],
                    'birthdate' => $_POST['birthdate'],
                    'email' => $_POST['email'],
                    'password' => hash("sha256", $password),
                    'gender' => $_POST['gender'],
                    'studyprog' => $_POST['studyprog'],
                    'language' => $_POST['language'],
                    'studyears' => $_POST['studyears'],
                    'comment' => $_POST['comment'],
                    'isAdmin' => false
                );

                $_SESSION['xml'] = $data; // Save last registered user into the SESSION variable
                $res = User::signup($data); // Inserting the data from the form into the database 

                // summary variable will contain Html content to display the data from the form
                $summary = <<<HTML
                    <article id="iwa1-summary-article">
                        <h2 id="iwa1-form-summary" class="title article-title">{$res}</h2>
                        <div class="user-infos-wrapper">
                            <p class="user-info-p">Name: {$data['name']}</p>
                            <p class="user-info-p">Firstname: {$data['firstname']}</p>
                            <p class="user-info-p">City: {$data['city']}</p>
                            <p class="user-info-p">Date of birth: {$data['birthdate']}</p>
                            <p class="user-info-p">Email: {$data['email']}</p>
                            <p class="user-info-p">Password: {$data['password']}</p>
                            <p class="user-info-p">Gender: {$data['gender']}</p>
                            <p class="user-info-p">Study Program: {$data['studyprog']}</p>
                            <p class="user-info-p">Language: {$data['language']}</p>
                            <p class="user-info-p">Years of study: {$data['studyears']}</p>
                            <p class="user-info-p">Comment: {$data['comment']}</p>
                        </div>

                        <form action="exportXML.php" id="xml-form" class="classic-form" method="post">
                            <div class="button-group">
                                <input type="submit" name="savedXML" value="Download XML File" class="form-button">
                            </div>
                        </form>
                    </article>
HTML;
            } else {
                $summary = <<<HTML
                    <article id="iwa1-summary-article">
                        <h2 id="iwa1-form-error" class="title article-title">Signup Form Error</h2>
                        <p class="error-line">The name, firstname or city should not contain numbers!</p>
                    </article>
HTML;
            }

        } else {
            $summary = <<<HTML
                <article id="iwa1-summary-article">
                    <h2 id="iwa1-form-error" class="title article-title">Signup Form Error</h2>
                    <p class="error-line">The password must be at least 8 characters long and contain uppercase, lowercase, and numbers!</p>
                </article>
HTML;
        }

    } else {
        // summary variable will contain an error message if POST does not match the requirements
        $summary = <<<HTML
            <article id="iwa1-summary-article">
                <h2 id="iwa1-form-error" class="title article-title">Signup Form Error</h2>
                <p class="error-line">The data from the form were not properly sent!</p>
            </article>
HTML;

    }

    $p->appendContent($summary); // Add content to the webpage
    echo $p->toHtml(); // Display the page
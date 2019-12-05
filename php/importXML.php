<?php

    // Required content
    require_once '../inc/root.include.php';
    require_once ROOT.'class/Webpage.class.php';
    require_once ROOT.'class/User.class.php';

    session_start(); // Get session global variable

    $p = new Webpage('KKPT'); // Creating new webpage

    if (isset($_POST['submit_xml_import'])) {
        $name = $_FILES['imported_xml']['name']; // Name of the file
        $tmpName = $_FILES['imported_xml']['tmp_name']; // Temporary location
        $error = $_FILES['imported_xml']['error']; // Error bounded to the file
        if (isset($name)) {
            if ($error > 0) {
                $content = <<<HTML
                    <p class="error-line">Error: {$error}!</p>
HTML;
            } else {
                $data = User::getXmlData($tmpName);

                if ($data['status']) {
                    $_SESSION['xml_users'] = $data['data'];

                    // Displaying the data
                    $formatedData = '';
                    foreach ($data['data'] as $user) {
                        $email = $user['email']; // Email of the user (id)
                        unset($user['email']); // Removing the email
                        $userInfos = implode(', ', $user);
                        $gender = ($user['gender'] == "male") ? "Mr" : "Ms";
                        $formatedData .= <<<HTML
                            <div class="user-infos-wrapper xml-user">
                                <p class="user-info-p"><span class="glyphicon glyphicon-user"></span> <span class="bold">{$email}</span></p>
                                <p class="user-info-p">{$gender} <span class="bold">{$user['name']} {$user['firstname']}</span></p>
                                <p class="user-info-p">Living in <span class="bold">{$user['city']}</span></p>
                                <p class="user-info-p">Born the <span class="bold">{$user['birthdate']}</span></p>
                                <p class="user-info-p">Following the <span class="bold">{$user['studyprog']}</span> program in <span class="bold">{$user['language']}</span></p>
                            </div>
HTML;
                    }

                    $p->appendContent(<<<HTML
                        <article id="iwa1-summary-article">
                            <h2 id="iwa1-form-summary" class="title article-title">These users will be imported to the database:</h2>
                            <div class="xml-users-wrapper">{$formatedData}</div>

                            <form id="xml-form" class="classic-form" method="post">
                                <div class="button-group">
                                    <input type="submit" name="xml_to_db" value="Save to Database" class="form-button">
                                </div>
                            </form>
                        </article>
HTML
                    );
                } else {
                    $p->appendContent(<<<HTML
                        <p class="error-line">Error: a filed was not properly set!</p>
HTML
                    );
                }
            }

        } else {
            $p->appendContent(<<<HTML
                <p class="error-line">Error: No file selected!</p>
HTML
            );
        }
    } else {
        // Admin wants to save xml into DB
        if (isset($_POST['xml_to_db'])) {
            if (isset($_SESSION['xml_users'])) {
                $data = $_SESSION['xml_users'];
                $multSignup = User::signupMultiple($data); // Signup the users
                $p->appendContent(<<<HTML
                    <p class="success-line">Success: the users have been saved into database!</p>
HTML
                );
            } else {
                $p->appendContent(<<<HTML
                    <p class="error-line">Error: SESSION data not set properly!</p>
HTML
                );
            }
        } else {
            $p->appendContent(<<<HTML
                <p class="error-line">Error: a problem occured while POSTing data to importXML script!</p>
HTML
        );
        }
    }

    echo $p->toHTML();
    exit;
?>


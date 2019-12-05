<?php

    // Required content
    require_once ROOT.'class/myPDO.class.php';
    require_once ROOT.'class/HTMLElement/Form/Form.class.php';
    require_once ROOT.'class/HTMLElement/Form/Input.class.php';
    require_once ROOT.'class/HTMLElement/Form/InputGroup.class.php';
    require_once ROOT.'class/HTMLElement/Form/RadioGroup.class.php';
    require_once ROOT.'class/HTMLElement/Form/Button.class.php';
    require_once ROOT.'class/HTMLElement/Form/Fieldset.class.php';
    require_once ROOT.'class/HTMLElement/Form/Select.class.php';

    /**
     * PHP class which describes a database User
     */
    class User {

        /**
         * Id of the user in database
         * @var int $id : user id
         */
        private $id = null;

        /**
         * Name of the user in database
         * @var String $name : name of the user
         */
        private $name = null;

        /**
         * Firstname of the user in database
         * @var String $firstname : firstname of the user
         */
        private $firstname = null;

        /**
         * City of the user in database
         * @var String $city : city of the user
         */
        private $city = null;

        /**
         * Birthdate of the user in database
         * @var Date $birthdate : birthdate of the user
         */
        private $birthdate = null;

        /**
         * Email address of the user in database, corresponding to the username
         * @var String $email : email address / username of the user
         */
        private $email = null;

        /**
         * Password of the user in database
         * @var String $password : encrypted password
         */
        private $password = null;

        /**
         * Gender of the user in database
         * @var String $gender : gender of the user
         */
        private $gender = null;

        /**
         * Study program of the user in database
         * @var String $studyprof : study program of the user
         */
        private $studyprog = null;

        /**
         * Study language of the user in database
         * @var String $language : study language of the user
         */
        private $language = 'lt';

        /**
         * Studies years of the user in database
         * @var int $studyears : study years of the user
         */
        private $studyears = 0;

        /**
         * Comment of the user in database
         * @var String $comment : comment of the user
         */
        private $comment = '';

        /**
         * Admin status of the user in database
         * @var boolean $isAdmin : whether the user is an admin or not
         */
        private $isAdmin = false;

        /**
         * Private constructor to prevent the creation of non-database user
         */
        private function __construct() {}

        /**
         * Getter for the id of the user
         * @return int $if : id of the user
         */
        public function getId() {
            return $this->id;
        }

        /**
         * Getter for the name of the user
         * @return String $name : name of the user
         */
        public function getName() {
            return $this->name;
        }

        /**
         * Getter for the firstname of the user
         * @return String $firstname : firstname of the user
         */
        public function getFirstName() {
            return $this->firstname;
        }

        /**
         * Getter for the city of the user
         * @return String $city : city of the user
         */
        public function getCity() {
            return $this->city;
        }

        /**
         * Getter for the birthdate of the user
         * @return Date $birthdate : birthdate of the user
         */
        public function getBirthDate() {
            return $this->birthdate;
        }

        /**
         * Getter for the username / email address of the user
         * @return String $email : email address of the user
         */
        public function getEmail() {
            return $this->email;
        }

        /**
         * Getter for the password of the user
         * @return String $password : password of the user
         */
        public function getPassword() {
            return $this->password;
        }

        /**
         * Getter for the gender of the user
         * @return String $gender : gender of the user
         */
        public function getGender() {
            return $this->gender;
        }

        /**
         * Getter for the study program of the user
         * @return String $studyprog : studyprog of the user
         */
        public function getStudyProg() {
            return $this->studyprog;
        }

        /**
         * Getter for the language of the user
         * @return String $language : language of the user
         */
        public function getLanguage() {
            return $this->language;
        }

        /**
         * Getter for the study years of the user
         * @return int   $studyears : study years of the user
         */
        public function getStudYears() {
            return $this->studyears;
        }

        /**
         * Getter for the comment of the user
         * @return String $comment : comment of the user
         */
        public function getComment() {
            return $this->comment;
        }

        /**
         * Getter for the admin status of the user
         * @return boolean $isAdmin : is the user an admin
         */
        public function getIsAdmin() {
            return $this->isAdmin;
        }

        /**
         * Checks if the given email address is already used in database
         * @param String $email : email to check in database
         * @return boolean $res : whether the email is already used or not
         */
        public static function checkEmail($email) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT * FROM User
                WHERE email = :email
SQL
            );

            $query->execute(array(':email' => $email)); // Execute the prepared query with the actual values
            return ($query->rowcount() === 1);
        }

        /**
         * Checks if the given id is already used in database
         * @param String $id : id to check in database
         * @return boolean $res : whether the id is already used or not
         */
        public static function checkId($id) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT * FROM User
                WHERE id = :id
SQL
            );

            $query->execute(array(':id' => $id)); // Execute the prepared query with the actual values
            return ($query->rowcount() === 1);
        }

        /**
         * Check if the given password match the password in database for the given username
         * @param String $username : username corresponding to the given password
         * @param String $password : password to check in database
         * @return boolean $res : whether the password matches or not
         */
        public static function checkUserPasswd($username, $password) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT password FROM User
                WHERE email = :username
SQL
            );

            $query->execute(array(':username' => $username)); // Execute the query with the actual values

            if (($dbPasswd = $query->fetch()) !== false) {
                $res = (hash('sha256', $password) === $dbPasswd['password']);
            } else $res = false;

            return $res;
        }

        /**
         * Creates an instance of User based on the given username / email address
         * @param String $username : email address of the user
         * @return User $res : instance based on the given username
         */
        public static function createFromUserName($username) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT * FROM User
                WHERE email = :username
SQL
            );

            $query->execute(array(':username' => $username)); // Execute the prepared query with the actual values
            $query->setFetchMode(PDO::FETCH_CLASS, 'User'); // Set the fetch mode

            return (($res = $query->fetch()) !== false) ? $res : "Impossible to create the user based on ".$username."!";
        }

        /**
         * Gets all the users registered in database
         * @return Array $users : users in database
         */
        public static function getAllUsers() {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT * FROM User
SQL
            );
            $query->execute(); // Execute the prepared query
            $users = array(); // Preparing the array of users
            
            // While there is users to retreive, we create and stock instances
            while(($user = $query->fetch()) !== false) {
                array_push($users, self::createFromUserName($user['email']));
            }

            return $users;
        }

        /**
         * Generates HTML table which contains all the users in database
         * @return HTMLContent $table : table containing the users
         */
        public static function getUserList() {
            $users = self::getAllUsers();
            $userRows = '';
 
            foreach ($users as $user) {
                $userRows .= <<<HTML
                    <tr class="user-list-row user-list-brow">
                        <td class="user-list-col">{$user->getId()}</td>
                        <td class="user-list-col">{$user->getName()}</td>
                        <td class="user-list-col">{$user->getFirstname()}</td>
                        <td class="user-list-col">{$user->getCity()}</td>
                        <td class="user-list-col">{$user->getEmail()}</td>
                        <td class="user-list-col">{$user->getStudyProg()}</td>
                        <td class="user-list-col">{$user->getIsAdmin()}</td>
                        <td class="user-list-col">
                            <p id="{$user->getId()}-delete-row" class="icon-row del-icon-row"><span id="{$user->getId()}-delete" class="glyphicon glyphicon-trash delete-user"></p>
                        </td>
                    </tr>
HTML;
            }

            $userlist = <<<HTML
                <table class="user-list" cellspacing="0">
                    <thead>
                        <tr class="user-list-row">
                            <th class="user-list-col user-list-hcol">Id</th>
                            <th class="user-list-col user-list-hcol">Name</th>
                            <th class="user-list-col user-list-hcol">Firstname</th>
                            <th class="user-list-col user-list-hcol">City</th>
                            <th class="user-list-col user-list-hcol">Email</th>
                            <th class="user-list-col user-list-hcol">Study Program</th>
                            <th class="user-list-col user-list-hcol">isAdmin</th>
                            <th class="user-list-col user-list-hcol">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$userRows}
                    </tbody>
                </table>
HTML;

            return $userlist;
        }

        /**
         * Generates HTML content to provide an Admin panel for the given admin user
         * @param String $username : email address of the admin user
         * @param HTMLContent $panel : admin panel
         */
        public static function getAdminPanel($username) {

            // Check if the session is properly set
            if (isset($_SESSION['user'])) {

                $user = $_SESSION['user'];
                $studyprog = $user->getStudyProg();

                // Re format the name of the study program
                switch ($studyprog) {
                    case 'multech':
                        $styProgName = 'Multimedia Technologies';
                        break;
                    case 'finance':
                        $styProgName = 'Finance Information Systems';
                        break;
                    default:
                        $styProgName = 'Computer Network Administration';
                        break;
                }

                $language = ($user->getLanguage() == 'en') ? 'English' : 'Lithuanian'; // Re format the language value
                $_SESSION['xml'] = self::getAllUsers(); // Get all the users from database
                $userlist = self::getUserList(); // Retreive the HTML content for the user list

                // Prepare the content of the panel
                $panel = <<<HTML
                <article class="adm-panel-article">
                    <h2 id="admin-panel-title" class="title article-title">{$username} 's admin panel</h2>
                    <div class="adm-panel-content">
                        <div id="adm-panel-resume" class="adm-panel-half">
                            <h4 class="title article-title adm-panel-half-title">User informations</h4>
                            <div class="logged-user-panel">
                                <div class="logged-user-halfpan">
                                    <p class="logged-user-p"><span class="glyphicon glyphicon-user user-info-icon"></span><span class="bold">Full name</span> : {$user->getFirstName()} {$user->getName()}</p>
                                    <p class="logged-user-p"><span class="glyphicon glyphicon-envelope user-info-icon"></span><span class="bold">Email address</span> : {$user->getEmail()}</p>
                                    <p class="logged-user-p"><span class="glyphicon glyphicon-map-marker user-info-icon"></span><span class="bold">City</span> : {$user->getCity()}</p>
                                    <p class="logged-user-p"><span class="glyphicon glyphicon-education user-info-icon"></span><span class="bold">Studies</span> : {$styProgName} in {$language}</p>
                                </div>
                                <div class="logged-user-halfpan">
                                    <form action="php/exportXML.php" id="xml-form" class="classic-form action-form" method="post">
                                        <div class="button-group">
                                            <input type="submit" name="savedXML" value="Export database as XML" class="form-button">
                                        </div>
                                    </form>
                                    <form enctype="multipart/form-data" action="php/importXML.php" id="xml-form" class="classic-form action-form" method="post">
                                        <div class="button-group">
                                            <input id="imported_xml" type="file" name="imported_xml" class="file-button" required>
                                            <input id="import-selected-xml" type="submit" name="submit_xml_import" value="Import XML" class="form-button">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="adm-panel-users" class="adm-panel-half">
                            <h4 class="title article-title adm-panel-half-title">User list</h4>
                            <div id="userlist-wrapper" class="table-wrapper">
                                {$userlist}
                            </div>
                        </div>
                    </div>
                </article>
HTML;
            } else {
                $panel = "No user is connected!"; // Set error message if the session is not properly set
            }

            return $panel;
        }

        /**
         * Simple method to return html content related to signup form
         * @return HTMLContent : signup form
         */
        public static function getSignupForm() {
            return <<<HTML
                <article id="signup-article">
                    <h2 id="signup-form-title" class="title article-title">Sign up Form</h2>
                        <form action="/KKPT/php/signup.php" id="signup-form" class="classic-form" method="post">
                            <fieldset id="personal-fs">
                                <legend>Personal informations</legend>
                                <div class="input-group">
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="signup-name" class="block-label" required="true">Name: </label>
                                            <input type="text" id="signup-name" name="name" placeholder="Name"
                                                class="lined-input text-input" required>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="signup-firstname" class="block-label" required="true">Firstname: </label>
                                            <input type="text" id="signup-firstname" name="firstname" placeholder="Firstname"
                                                class="lined-input text-input" required>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="signup-city" class="block-label" required="true">City: </label>
                                            <input type="text" id="signup-city" name="city" placeholder="City"
                                                class="lined-input text-input" required>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="signup-birthdate" class="block-label" required="true">Date of birth: </label>
                                            <input type="date" id="signup-birthdate" name="birthdate"
                                                class="lined-input text-input" max="2009-12-31" required>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="signup-email" class="block-label" required="true">Email address: </label>
                                            <input type="email" id="signup-email" placeholder="E-mail"
                                                class="lined-input text-input" name="email" required>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="signup-passwd" class="block-label" required="true">Password: </label>
                                            <input type="password" id="signup-passwd" name="passwd" placeholder="Password"
                                                class="lined-input text-input" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="radio-group">
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label class="block-label" required="true">Gender</label>

                                            <input id="signup-female" type="radio" value="female" name="gender" class="radio-input" checked>
                                            <label for="female" class="radio-label">Female</label>

                                            <input id="signup-male" type="radio" value="male" name="gender" class="radio-input">
                                            <label for="male" class="radio-label">Male</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset id="personal-fs">
                                <legend>Additional informations</legend>
                                <div class="input-group">
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="studyprog" class="block-label" required="true">Study Program</label>
                                            <select id="signup-studyprog" name="studyprog" class="lined-input text-input">
                                                <option value="multech">Multimedia technology</option>
                                                <option value="network">Computer Network Administration</option>
                                                <option value="finance">Information Finance Systems</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="language" class="block-label" required="true">Language</label>
                                            <select id="signup-lang" name="language" class="lined-input text-input">
                                                <option value="lt">Lithuanian</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-block">
                                        <div class="input-wrapper">
                                            <label for="studyears" class="block-label">Years of Study: </label>
                                            <input type="number" id="signup-studyears" name="studyears" placeholder="0"
                                                class="lined-input text-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="textarea-block">
                                        <div class="textarea-wrapper">
                                            <label for="comment" class="block-label">Comment</label>
                                            <textarea id="signup-comment" name="comment" maxlength="200"
                                                class="lined-input text-input comment"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="button-group">
                                <button type="submit" class="form-button">Submit</button>
                                <button type="reset" class="form-button">Reset</button>
                            </div>
                        </form>
                </article>
HTML;
        }

        /**
         * Saves given data in an XML file
         * @param Array data : array of users
         * @return boolean : whether the file was successfully saved or not
         */
        public static function exportXML($title, $users) {
            $dom = new DOMDocument('1.0', 'utf-8'); // Creating a new DOM documen
            $dom->formatOutput = true; // To make the result more readable

            $root = $dom->createElement('userlist'); // Creating root node

            // For each user we create a node user
            foreach ($users as $user) {
                $userNode = $dom->createElement('user'); // New user node

                // For each property of the user we create a new attribute
                foreach ($user as $key => $value) {
                    $attr = $dom->createElement($key); // New attribute for the user node

                    // Handling boolean
                    if (is_bool($value)) $value = var_export($value, true);
                    else $value = $value;

                    $attr->nodeValue = $value; // Set the attribute value
                    $attr = $userNode->appendChild($attr); // Appending attribute to the node
                }

                $userNode = $root->appendChild($userNode); // Appending the user node to the userlist
            }

            $root = $dom->appendChild($root); // Appending root node to the document

            // Saving the data in an XML file with given title
            $saved = $dom->saveXml();

            // Calls for file saving
            $handle = fopen($title, "w");
            fwrite($handle, $saved);
            fclose($handle);

            header('Content-Type: text/xml');
            header('Content-Disposition: attachment; filename='.basename($title));
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($title));
            readfile($title); // For opening file

            return $saved;
        }

        /**
         * Generates an array of data based on the given xmlFile
         * @param String $xmlFile : xml file
         * @return Array $userData : data contained in the xmlFile
         */
        public static function getXmlData(String $xmlFile) {
            $xml = simplexml_load_file($xmlFile); // Loading the xml file
            $usersData = array();

            // For each node, get the attributes and put them in an array
            foreach ($xml->children() as $user) {
                $userAttr = array();
                foreach ($user->children() as $attr => $value) {
                    $userAttr[$attr] = (String)$value;
                }

                // Checks if required fields are set
                if (!isset($userAttr['name'])
                    || !isset($userAttr['firstname'])
                    || !isset($userAttr['city'])
                    || !isset($userAttr['birthdate'])
                    || !isset($userAttr['email'])
                    || !isset($userAttr['passwd'])
                    || !isset($userAttr['gender'])
                    || !isset($userAttr['studyprog'])
                    || !isset($userAttr['language'])) {
                    
                    return array('status' => false, 'data' => null);
                }

                $userAttr['isAdmin'] = false; // Setting isAdmin status
                if (!isset($userAttr['comment'])) $userAttr['comment'] = "";
                if (!isset($userAttr['studyears'])) $userAttr['studyears'] = "";

                // Encrypting the password
                if (!isset($userAttr['password'])) {
                    $passwd = str_pad($userAttr['name'], 8, "0");
                    $userAttr['password'] = hash("sha256", $passwd);
                }

                array_push($usersData, $userAttr);
            }

            return array('status' => true, 'data' => $usersData);
        }

        /**
         * Allows to signup mltiple users (xml import)
         * @param Array $users : users to signup
         */
        public static function signupMultiple(Array $users) {
            foreach ($users as $user) self::signup($user);
        }

        /**
         * Checks if the given password has the right format
         * @param String $password : password to check
         * @return Boolean : whether or not the password is checked
         */
        public static function checkPasswdFormat(String $password) {
            $uppercase = preg_match('@[A-Z]@', $password); // Checks if the password contains uppercase
            $lowercase = preg_match('@[a-z]@', $password); // Checks if the password contains lowercase
            $number = preg_match('@[0-9]@', $password); // Checks if the password contains at least one number
            $length = strlen($password) >= 8 && strlen($password) < 15; // Checks the length of the password

            return ($uppercase && $lowercase && $number && $length);
        }

        /**
         * Allows someone to sign up as a user
         * @param Array $data : array containing the user data
         * @return boolean : whether the sign up is a success or not
         */
        public static function signup(Array $data) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO
            $email = $data['email'];

            if (self::checkEmail($email)) {
                $res = <<<HTML
                    <span class="glyphicon glyphicon-remove signup-icon signup-icon-error"></span>
                    <span class='signup-msg'>Error: The user {$email} already exists!</span>
HTML;
            } else {
                // Prepare the query to prevent SQL injection
                $query = $pdo->prepare(<<<SQL
                    INSERT INTO User (name, firstname, city, birthdate, email, password, gender, studyprog, language, studyears, comment, isAdmin)
                    VALUES (:name, :firstname, :city, :birthdate, :email, :password, :gender, :studyprog, :language, :studyears, :comment, :isAdmin)
SQL
                );

                // Execute the prepared query with the actual values
                $query->execute(array(
                    ':name' => $data['name'],
                    ':firstname' => $data['firstname'],
                    ':city' => $data['city'],
                    ':birthdate' => $data['birthdate'],
                    ':email' => $email,
                    ':password' => $data['password'],
                    ':gender' => $data['gender'],
                    ':studyprog' => $data['studyprog'],
                    ':language' => $data['language'],
                    ':studyears' => $data['studyears'],
                    ':comment' => $data['comment'],
                    ':isAdmin' => $data['isAdmin'],
                ));

                $res = <<<HTML
                    <span class="glyphicon glyphicon-ok signup-icon signup-icon-success"></span>
                    <span class='signup-msg'>Success: The user {$email} was successfully added to the database!</span>
HTML;
            }

            return $res;
        }

        /**
         * Sign the user in if he exists and if he is an admin
         * @param String $username : username of the user which is trying to sign in
         * @param String $password : password of the user which is trying to sign in
         * @return User $res : instance of the user
         */
        public static function signin($username, $password) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT password, isAdmin FROM User
                WHERE email = :username
SQL
            );

            $query->execute(array(':username' => $username)); // Execute the prepared query with the actual values

            // Check if the user actually exists in the database
            if ($query->rowcount() == 1) {
                $dbValues = $query->fetch(); // Retreive data from the DB
                
                // Check if the user is an admin
                if ($dbValues['isAdmin']) {

                    // Check if the password is valid
                    $enteredPasswd = hash('sha256', $password);
                    if ($enteredPasswd == $dbValues['password']) {
                        $res = self::createFromUserName($username); // Create instance corresponding to the data in DB
                    } else $res = "Invalid password!";

                } else $res = "The user ".$username." is not an admin!";

            } else $res = "Unknown user ".$username."!";

            return $res;
        }

        /**
         * Checks if the given user is an admin
         * @param Integer id : id of the user
         * @return boolean : whether or not the user is an admin
         */
        public static function checkAdminStatus($id) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            // Prepare the query to prevent SQL injection
            $query = $pdo->prepare(<<<SQL
                SELECT isAdmin FROM User
                WHERE id = :id
SQL
            );

            $res = $query->execute(array(':id' => $id)); // Execute the prepared query with the actual values

            if (($adminStatus = $query->fetch()) !== false) {
                $res = ($adminStatus['isAdmin'] === 1);
            } else $res = false;

            return $res;
        }

        /**
         * Deletes a user from database based on given username
         * @param String username : username of the user to delete
         * @return
         */
        public static function deleteUser($id) {
            $pdo = myPDO::getInstance(); // Get the instance of myPDO

            if (self::checkId($id)) {
                if (!self::checkAdminStatus($id)) {
                    // Prepare the query to prevent SQL injection
                    $query = $pdo->prepare(<<<SQL
                        DELETE FROM User
                        WHERE id = :id
SQL
                    );

                    $query->execute(array(':id' => $id)); // Execute the prepared query with the actual values
                    $res = array("status" => "success", "msg" => "The user {$id} was successfully deleted!");
                } else {
                    $res = array("status" => "error", "msg" => "The user {$id} is an administrator!");
                }
            } else {
                $res = array("status" => "error", "msg" => "The user {$id} does not exist!");
            }

            return $res;
        }
    }
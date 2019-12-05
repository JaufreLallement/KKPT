<?php

    /**
     * PHP class to describe the behavior of a webpage
     */
    class Webpage {
        /**
         * Content of the html head between <head> and </head>
         * @var HTMLContent $head
         */
        private $head  = null;

        /**
         * Title of the page between <title> and </title>
         * @var String $title
         */
        private $title = null;

        /**
         * Content of the webpage between <body> and </body>
         * @var String $body
         */
        private $body  = null;

        /**
         * Constructor for the class
         * @param String $title : Title of the page
         * @return Webpage : implicit return of a Webpage instance
         */
        public function __construct(String $title = null) {
            $this->setTitle($title);
        }

        /**
         * Set the title of the page
         * @param String $title : title to set
         * @return void
         */
        public function setTitle($title) {
            $this->title = $title;
        }

        /**
         * Add content to the html head
         * @param HTMLContent $content : content to append
         * @return void
         */
        public function appendToHead($content) {
            $this->head .= $content;
        }

        /**
         * Set the webpage content based on parameters
         * @param HTMLContent $content : content to set
         * @return void
         */
        public function setContent($content) {
            $this->body = $content;
        }

        /**
         * Append content to the webpage based on parameters
         * @param HTMLContent $content : content to append
         * @return void
         */
        public function appendContent($content) {
            $this->body .= $content;
        }

        /**
         * Returns the html content of the webpage
         * @throws Exception if the title is not set
         * @return HTMLContent : html content of the webpage
         */
        public function toHTML() {
            //Check if the title of the webpage has been set
            if (is_null($this->title)) {
                throw new Exception(__CLASS__ . ": title not set"); // Throw exception if the title is not set
            }

            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                $loggedIcon = <<<HTML
                <a href="http://localhost/KKPT/php/signout.php" class="link">
                    <p class="icon-row logged-icon-row">
                        {$user->getEmail()}
                        <span class="glyphicon glyphicon-off logged-icon">
                    </p>
                </a>
HTML;
            } else {
                $loggedIcon = <<<HTML
                <a href="http://localhost/KKPT/php/signin.php" class="link">
                    <p class="icon-row logged-icon-row"><span class="glyphicon glyphicon-user signin"></p>
                </a>
HTML;
            }

            // Html pattern of the webpage
            return <<<HTML
                <!doctype html>
                <html lang="en" xml:lang="en">
                    <head>
                        <!-- Basic Page Needs
                        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
                        <meta charset="utf-8">
                        <meta name="keywords" content="text/html">
                        <meta name="author" content="Lallement Jaufré">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>{$this->title}</title>

                        <!-- CSS
                        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
                        <link rel="stylesheet" type="text/css" href="/KKPT/css/glyphicon.css">
                        <link rel="stylesheet" type="text/css" href="/KKPT/css/main.css">
                    </head>

                    <body>
                        <!-- Header
                        ––––––––––––––––––––––––––––––––––––––––––––––––– -->
                        <header id="header" class="flexed-row">
                            <a href="http://localhost/KKPT/index.php" class="home-link"><img src="/KKPT/img/logo-header1.png" alt="KK" class="logo"></a>
                            <h1 id="main-title" class="title">{$this->title}</h1>
                            {$loggedIcon}
                        </header>

                        <!-- Main Content
                        ––––––––––––––––––––––––––––––––––––––––––––––––– -->
                        <section id="content">
                            {$this->body}
                        </section>

                        <!-- Footer
                        ––––––––––––––––––––––––––––––––––––––––––––––––– -->
                        <footer class="flexed-column">
                            <p class="copyright">&copy; - Lallement Jaufré 2019</p>
                        </footer>
                    </body>

                    <!-- JAVASCRIPT
                    ––––––––––––––––––––––––––––––––––––––––––––––––– -->
                    <script type='text/javascript' src='js/ajaxFunctions.js'></script>
                    <script type='text/javascript' src='js/deleteUser.js'></script>
                </html>
HTML;
        }
    }

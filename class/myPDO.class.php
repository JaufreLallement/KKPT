<?php

    // Required content
    require_once ROOT.'inc/myPDO.include.php';

    final class myPDO {
        /**
         * myPDO unique instance
         * @var myPDO $_PDOInstance : instance of the class
         */
        private static $_PDOInstance = null;

        /**
         * DNS to the database
         * @var String $_DNS : used dns
         */
        private static $_DNS = null;

        /**
         * Username for database connection
         * @var String $_username : username
         */
        private static $_username = null;

        /**
         * Password for database connection
         * @var String $_password : password
         */
        private static $_password = null;

        /**
         * Driver options
         * @var Array $_driverOptions : list of driver options
         */
        private static $_driverOptions = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        /**
         * Private Constructor
         */
        private function __construct() {
            /*
            * Prevent useless instance of PDO
            */
        }

        /**
         * Access point to the unique instance of the class
         * @throws Exception if no configuration was done
         *
         * @return myPDO $_PDOInstance : unique instance of the class
         */
        public static function getInstance() {
            if (is_null(self::$_PDOInstance)) {
                if (self::hasConfiguration()) {
                    self::$_PDOInstance = new PDO(self::$_DNS, self::$_username, self::$_password, self::$_driverOptions) ;
                }
                else {
                    throw new Exception(__CLASS__ . ": Configuration not set") ;
                }
            }
            return self::$_PDOInstance ;
        }

        /**
         * Configure the database connection
         * @param String $dns DNS to the database
         * @param String $username username for the database connection
         * @param String $password password for database connection
         * @param Array $driver_options driver options for DB
         *
         * @return void
         */
        public static function setConfiguration($dns, $username='', $password='', array $driver_options=array()) {
            self::$_DNS = $dns;
            self::$_username = $username;
            self::$_password = $password;
            self::$_driverOptions = $driver_options + self::$_driverOptions;
        }

        /**
         * Check if the configuration has been done
         *
         * @return bool
         */
        private static function hasConfiguration() {
            return self::$_DNS !== null ;
        }
    }

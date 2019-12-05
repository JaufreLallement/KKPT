<?php

    // Required content
    require_once ROOT.'class/HTMLElement/Form/Input.class.php';

    /**
     * PHP class allowing the creation of html select element
     */
    class Select extends Input {

        /**
         * Options of the select element
         * @var Array $options
         */
        private $options = array();

        /**
         * Constructor for the Select class
         * @param Array $attr : attributes of the element
         * @param Array $option : options of the select
         */
        public function __construct(String $label, Array $attr = array(), Array $options = array()) {
            parent::__construct($label, $attr, $tagName = "select");
            $this->setOptions($options);
        }

        /**
         * Allows to add a new option to the select
         * @param String $value : value attribute of the option
         * @param String $text : displayed text of the option
         */
        public function addOption(String $value, String $text) {
            array_push($this->options, array('value' => $value, 'text' => $text));
        }

        /**
         * Checks if the options have the right format
         * @param Array $options : options to check
         * @return Boolean $checked : whether or not the options are valid
         */
        private function checkOptions(Array $options) {
            $checked = true;
            foreach ($options as $option) {
                if (!(is_array($option) && (isset($option['value']) && isset($option['text'])))) {
                    $checked = false;
                    throw new Exception("Error: options must be arrays and must contain a value and a text field!", 1);
                    break;
                }
            }
            return $checked;
        }

        /**
         * Allows to set the options of the select element
         * @param Array $option : options to set
         */
        public function setOptions(Array $options) {
            if (!empty($options)) {
                if (!$this->checkOptions($options)) return;
            }
            $this->options = $options;
        }

        /**
         * Generates the html content for the instance of Select
         */
        public function toHtml() {
            $required = isset($this->attr['required']);
            foreach ($this->options as $option) {
                $this->appendContent(<<<HTML
                    <option value="{$option['value']}">{$option['text']}</option>
HTML
                );
            }
            return $this->getDefaultHtml($this->attr['id'], $required);
        }
    }
    
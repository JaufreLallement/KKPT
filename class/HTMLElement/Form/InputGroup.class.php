<?php

    // Required content
    require_once ROOT.'class/HTMLElement/Form/Input.class.php';

    /**
     * PHP class allowing the creation of input groups
     */
    class InputGroup extends HTMLElement {
        /**
         * Label of the group
         * @var String $groupLabel
         */
        private $groupLabel = "";

        /**
         * Array containing the inputs of the group
         * @var Array $inputs
         */
        private $inputs = array();

        /**
         * Constructor for the class InputGroup
         * @param String $attr : 
         */
        public function __construct(String $groupLabel = "", Array $attr = array(), Array $inputs = array()) {
            parent::__construct($tagName = "div", $attr);
            $this->setGroupLabel($groupLabel);
            $this->setInputs($inputs);
        }

        /**
         * Allows to set the label of the group
         * @param String $label : label to set
         */
        public function setGroupLabel(String $label) {
            $this->groupLabel = $groupLabel;
        }

        /**
         * This method allows to add an input to the input group
         * @param Input $input : input to add
         */
        public function addInput(Input $input) {
            array_push($this->inputs, $input);
        }

        /**
         * Checks if the given array contains only Input instances
         * @param Array $inputs : array to check
         * @return Boolean $checked : whether or not the array contains only Input instances
         */
        private function checkInputs(Array $inputs) {
            $checked = true;
            foreach ($inputs as $input) {
                if (!($input instanceof Input)) {
                    $checked = false;
                    throw new Exception("Error: InputGroup instances must only be provided Input instances!", 1);
                    break;
                }
            }
            return $checked;
        }

        /**
         * Set the inputs of the InputGroup
         * @param Array $inputs : inputs to set
         */
        public function setInputs(Array $inputs) {
            if (!empty($inputs)) {
                if (!$this->checkInputs($inputs)) return;
            }
            $this->inputs = $inputs;
        }

        /**
         * This method generates HTMLContent based on the instance of the class
         * @return HTMLContent : html content for the instance
         */
        public function toHtml() {
            // Get html for each input of the group
            foreach ($this->inputs as $input) {
                $this->appendContent(<<<HTML
                    <div class="input-block">
                        <div class="input-wrapper">
                            {$input->toHtml()}
                        </div>
                    </div>
HTML
                );
            }
            return $this->buildElement();
        }
    }
    
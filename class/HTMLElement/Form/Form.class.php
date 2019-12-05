<?php

    // Required content
    require_once ROOT.'class/HTMLElement/HTMLElement.class.php';

    /**
     * PHP class allowing the creation of html forms
     */
    class Form extends HTMLElement {
        /**
         * Constructor for the Form class
         * @param String $attr : attributes of the form
         * @param String $action : action the form will execute once submitted
         */
        public function __construct(String $action, Array $attr = array(), String $method = "post") {
            $options = array('action' => $action, 'method' => $method);
            parent::__construct($tagName = "form", $attr = array_merge($attr, $options));
            $this->setAction($action);
        }

        /**
         * Allows to set the form action
         * @param String $action : php script url
         */
        public function setAction(String $action) {
            $this->setOneAttr("action", $action);
        }

        /**
         * This method generates HTMLContent based on the instance of the class
         * @return HTMLContent : html content for the instance
         */
        public function toHtml() {
            $this->appendContent(<<<HTML
                <div class="button-group">
                    <button type="submit" class="form-button">Submit</button>
                    <button type="reset" class="form-button">Reset</button>
                </div>
HTML
            );

            return $this->buildElement();
        }
    }
    
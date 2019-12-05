<?php

    // Required content
    require_once ROOT.'class/HTMLElement/HTMLElement.class.php';

    /**
     * PHP class allowing to create html buttons
     */
    class Button extends HTMLElement {

        /**
         * Text of the button
         * @var String $text
         */
        private $text = "New_button";

        /**
         * Constructor for the Button class
         * @param String $attr : attributes of the button
         * @param String $type : type of the button
         * @param String $text : text of the button
         */
        public function __construct(String $text = "New_button", Array $attr = array(), String $type = "submit") {
            parent::__construct($tagName = "button", $attr = array_merge($attr, array('type' => $type)));
            $this->setText($text);
        }

        /**
         * Allows to set the button type
         * @param String $type : type to set
         */
        public function setByttonType(String $type) {
            $this->setOneAttr("type", $type);
        }

        /**
         * Allows to set the text of the button
         * @param String $text : text of the button
         */
        public function setText($text) {
            $this->text = $text;
        }

        /**
         * Generates the html content for the instance of Button
         */
        public function toHtml() {
            $this->setContent($this->text);
            return $this->buildElement();
        }
        
    }
    
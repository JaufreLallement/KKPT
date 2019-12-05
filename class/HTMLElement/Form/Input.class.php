<?php

    // Required content
    require_once ROOT.'class/HTMLElement/HTMLElement.class.php';

    /**
     * PHP class allowing the creation of html inputs
     */
    class Input extends HTMLElement {
        /**
         * Text of the input label
         * @var String $label
         */
        protected $label = "";

        /**
         * Constructor for the Input class
         * @param String $tagName : tag of the element (input or textarea)
         * @param Array $attr : attributes of the element
         * @param String $label : label of the element
         */
        public function __construct(String $label, Array $attr = array(), String $tagName = "input") {
            parent::__construct($tagName, $attr);
            $this->setLabel($label);
        }

        /**
         * Allows to get the label value of the input
         * @return String $label
         */
        public function getLabel() {
            return $this->label;
        }

        /**
         * Allows to set the input label text
         * @param String $label : label of the input
         */
        public function setLabel(String $label) {
            $this->label = $label;
        }

        /**
         * This method generates HTMLContent based on the instance of the class
         * @return HTMLContent : html content for the instance
         */
        public function toHtml() {
            $inputId = $this->attr['id'] ?: "";
            $required = isset($this->attr['required']);
            $type = $this->attr['type'];

            $label = <<<HTML
                <label for="{$id}" class="block-label" required="{$required}">{$this->label}: </label>
HTML;
            if ($type === "radio") {
                $html = <<<HTML
                    {$this->buildElement()}
                    {$label}
HTML;
            } else {
                $html = <<<HTML
                    {$label}
                    {$this->buildElement()}
HTML;
            }

            return $html;
        }
    }
    
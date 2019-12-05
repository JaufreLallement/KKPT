<?php

    // Required content
    require_once ROOT.'class/HTMLElement/HTMLElement.class.php';

    /**
     * PHP Class to generate form fieldset
     */
    class ClassName extends HTMLElement {
        /**
         * Legend of the fieldset
         * @var String $legend
         */
        private $legend = "";

        /**
         * Construtor for the Fieldset class
         * @param String $attr : attributes of the element
         * @param String $legend : legend text
         */
        public function __construct(String $legend, Array $attr = array()) {
            parent::__construct($tagName = "fieldset", $attr);
            $this->setLegend($legend);
        }

        /**
         * Allows to set the legend text of the fieldset
         * @param String $legend : text of the legend
         */
        public function setLegend($legend) {
            $this->legend = $legend;
        }

        /**
         * This method generates HTMLContent based on the instance of the class
         * @return HTMLContent : html content for the instance
         */
        public function toHtml() {
            $this->setContent(<<<HTML
                <legend>{$this->legend}</legend>
                {$this->content}
HTML
            );
            return $this->buildElement();
        }
    }
    
<?php

    /**
     * PHP abstract class descibing basic HTML element
     */
    abstract class HTMLElement {
        /**
         * Tag name of the element
         * @var String $tagName
         */
        protected $tagName = "div";

        /**
         * Attributes of the element
         * @var Array $attr
         */
        protected $attr = array();

        /**
         * Content of the element
         * @var HTMLContent $content
         */
        protected $content = null;

        /**
         * Constructor for the class HTMLElement
         * @param String $id : id of the element
         * @param String $class : class of the element
         */
        protected function __construct(String $tagName = "div", Array $attr = array()) {
            $this->setTagName($tagName);
            $this->setAttr($attr);
        }

        /**
         * Allows to set the tag name of the html element
         * @param String $tagName : tag name to set
         */
        protected function setTagName(String $tagName) {
            $this->tagName = $tagName;
        }

        /**
         * Allows to get the attributes of an element
         * @return Array $attr
         */
        public function getAttr() {
            return $this->attr;
        }

        /**
         * Allows to set the class of the element
         * @param Array $attr : attributes to set
         */
        protected function setAttr(Array $attr) {
            $this->attr = $attr;
        }

        /**
         * Allows to set one particular attribute of the element
         * @param String $attr : attribute to set
         * @param * $value : value to set to the attribute
         */
        protected function setOneAttr(String $attr, $value) {
            $this->attr[$attr] = $value;
        }

        /**
         * Allows to add a new attribute to the element
         * @param String $attr : attribute to add
         */
        protected function addAttr(String $attr) {
            array_push($this->attr, $attr);
        }

        /**
         * Allows to remove an attribute from the element
         * @param String $attr : attribute to remove
         */
        protected function removeAttr(String $attr) {
            unset($this->attr["{$attr}"]);
        }

        /**
         * Allows to set the content of the element
         * @param HTMLContent $content : content to set
         */
        protected function setContent($content) {
            $this->content = $content;
        }

        /**
         * Allows to append content to the element
         * @param HTMLContent $content : content to append
         */
        protected function appendContent($content) {
            $this->content .= $content;
        }

        /**
         * Allows to append a class to the class list of the element
         * @param String $class : class to add
         */
        protected function appendClass(String $class) {
            if (isset($this->attr['class'])) $this->attr['class'] .= " ".$class;
        }

        /**
         * Allows to remove a class from the class list of the element
         * @param String $class : class to remove
         */
        protected function removeClass(String $class) {
            if (isset($this->attr['class'])) str_replace($class, "", $this->attr['class']);
        }

        /**
         * Generates a string based on an array of html attributes
         * @param Array $attr : attributes
         * @return String $attrString : attributes
         */
        private function generateAttrString(Array $attr = array()) {
            $attrString = '';
            if (!empty($attr)) foreach ($attr as $key => $value) $attrString .= $key."=".'"'.$value.'" '; // Generating the string
            return trim($attrString); // Return the attribute string and removes the whitespaces on each sides
        }

        /**
         * Generates the opening tag of an html element
         * @param String $tagName : tag name of the element
         * @param Array $attr : attributes
         * @return String : opening tag of the element
         */
        private function openinTag(String $tagName, $attr = array()) {
            $attrString = $this->generateAttrString($attr);
            return "<".$tagName." ".$attrString.">";
        }

        /**
         * Generates the closing tag of an html element
         * @param String $tagName : tag name of the element
         * @return String : closing tag of the element
         */
        private function closingTag(String $tagName) {
            return "</".$tagName.">";
        }

        /**
         * Generates a dynamic HTML element
         * @return String : html tag of the element
         */
        protected function buildElement() {
            return openinTag($this->tagName, $this->attr).$this->content.closingTag($this->tagName);
        }

        /**
         * ABSTRACT method to be defined by children classes
         * This method should allow to convert instance of children classes into HTML content
         */
        abstract protected function toHtml();
    }
    
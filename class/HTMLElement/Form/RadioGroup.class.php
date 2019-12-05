<?php

    // Required content
    require_once ROOT.'class/HTMLElement/Form/InputGroup.class.php';

    /**
     * PHP class to generate radio group
     */
    class RadioGroup extends InputGroup {

        /**
         * Constructor for the RadioGroup class
         * @param Array $attr : attributes of the element
         * @param Array $radios : radios of the group
         */
        public function __construct(String $groupLabel = "", Array $attr = array(), Array $radios = array()) {
            parent::__construct($groupLabel, $attr, $radios);
        }

        /**
         * This method generates HTMLContent based on the instance of the class
         * @return HTMLContent : html content for the instance
         */
        public function toHtml() {
            $required = isset($this->attr['required']);
            foreach ($this->inputs as $input) $radiosHtml .= $input->toHtml();

            $this->appendContent(<<<HTML
                <div class="input-block">
                    <div class="input-wrapper">
                        <label class="block-label" required="{$required}">{$this->groupLabel}</label>
                        {$radiosHtml}
                    </div>
                </div>
HTML
            );
            return $this->buildElement();
        }
    }
    
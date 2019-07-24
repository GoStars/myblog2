<?php
    namespace Myblog2\Template;

    interface Renderer {
        public function render($template, $data = []) : string;
    }

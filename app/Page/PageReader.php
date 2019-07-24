<?php
    namespace Myblog2\Page;

    interface PageReader {
        public function readBySlug(string $slug) : string;
    }

<?php
    return [
        ['GET', '/projects/myblog2/public/', ['Myblog2\Controllers\Homepage', 'show']],
        ['GET', '/projects/myblog2/public/{slug}', ['Myblog2\Controllers\Page', 'show']],
    ];
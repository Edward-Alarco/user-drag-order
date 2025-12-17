<?php

add_filter('plugin_row_meta', function ($links, $file) {

    if ($file !== plugin_basename(UDO_PLUGIN_FILE)) {
        return $links;
    }

    $links[] = '<a href="https://github.com/Edward-Alarco/user-drag-order" target="_blank" rel="noopener noreferrer">Documentation</a>';

    return $links;
}, 10, 2);
<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Force ORDER BY wp_users.user_order when requested
 */
add_action('pre_user_query', function ($query) {

    if (
        isset($query->query_vars['orderby']) &&
        $query->query_vars['orderby'] === 'user_order'
    ) {
        global $wpdb;

        $order = (!empty($query->query_vars['order']) && strtoupper($query->query_vars['order']) === 'DESC')
            ? 'DESC'
            : 'ASC';

        $query->query_orderby = "ORDER BY {$wpdb->users}.user_order {$order}";
    }
});

/**
 * Force users.php to load ordered by user_order
 */
add_action('pre_get_users', function ($query) {

    if (!is_admin() || !$query instanceof WP_User_Query) {
        return;
    }

    global $pagenow;
    if ($pagenow !== 'users.php') {
        return;
    }

    // Respect manual sorting (clicking column headers)
    if (!empty($_GET['orderby'])) {
        return;
    }

    $query->set('orderby', 'user_order');
    $query->set('order', 'ASC');
});
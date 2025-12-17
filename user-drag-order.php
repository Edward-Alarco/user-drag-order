<?php
/**
 * Plugin Name: User Drag Order
 * Description: Drag & drop ordering for WordPress users using wp_users.user_order
 * Version: 1.0.0
 * Author: Edward Alarco
 * Author URI: https://edward-alarco.github.io/edwardalarco/
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) exit;

define('UDO_PLUGIN_FILE', __FILE__);

// Autoload simple
require_once plugin_dir_path(__FILE__) . 'includes/plugin-links.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-user-drag-order.php';
require_once plugin_dir_path(__FILE__) . 'includes/user-order-query.php';

// Init
new User_Drag_Order();
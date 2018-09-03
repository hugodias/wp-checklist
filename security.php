<?php
/**
 * Scripts to improve Wordpress theme security
 */

/**
 * Remove wordpress version from head for security reasons
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove wordpress version from RSS
 *
 * @return string
 */
function remove_wp_version()
{
    return '';
}

add_filter('the_generator', 'remove_wp_version');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Disable pingbacks
 */
add_filter('wp_headers', 'disable_x_pingback');
function disable_x_pingback($headers)
{
    unset($headers['X-Pingback']);

    return $headers;
}
<?php
/**
 * Routing Helper
 * Provides functions to convert legacy .php file links to CI4 routes
 */

if (! function_exists('legacyRoute')) {
    /**
     * Convert legacy PHP file references to CI4 routes
     * Examples:
     *   legacyRoute('admin/members.php') => '/admin/members'
     *   legacyRoute('add-member-req.php') => '/admin/add-member'
     *   legacyRoute('actions/delete-member.php') => '/admin/delete-member'
     */
    function legacyRoute($file)
    {
        // Remove .php extension
        $file = preg_replace('/\.php$/', '', $file);

        // Remove leading/trailing slashes and normalize
        $file = trim($file, '/');

        // Map common legacy paths to CI4 routes
        // This is a simple passthrough for now - you may extend with specific mappings
        return base_url($file);
    }
}

if (! function_exists('linkRewrite')) {
    /**
     * Rewrite a URL with legacy .php to modern route
     * Used in filters to auto-convert links in HTML
     */
    function linkRewrite($url)
    {
        // Skip absolute URLs and #anchors
        if (preg_match('/^(https?:|\/\/|#)/', $url)) {
            return $url;
        }

        // Remove .php and convert to base_url
        if (preg_match('/\.php($|\?)/', $url)) {
            $url = preg_replace('/\.php($|\?)/', '$1', $url);
        }

        return $url;
    }
}
?>

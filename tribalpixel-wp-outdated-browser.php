<?php
/**
 * Plugin Name: Tribalpixel WP Outdated Browser
 * Description: This plugin show a message if your browser is outdated.
 * Version: 1.0.0
 * Author: Ludovic Bortolotti
 * Author URI: http://www.tribalpixel.ch
 * License: MIT
 */
if (!defined('ABSPATH')) {
    exit;
}

class tribalpixelOutdatedBrowser {

    private $pluginPath;
    private $pluginLang;
    private $libVersion;

    public function __construct() {

        $this->pluginPath = plugin_dir_url(__FILE__);
        $this->libVersion = "1.1.2";
        $this->pluginLang = "fr";
        
        // add scripts and html markup
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
        add_action('wp_footer', array($this, 'add_html'));
        add_action('wp_head', array($this, 'init_js'));
    }

    /**
     * Enqueue CSS and JS
     */
    public function add_scripts() {
        $css = $this->pluginPath . 'outdatedbrowser.min.css';
        $js = $this->pluginPath . 'outdatedbrowser.min.js';
        wp_enqueue_style('tp-outdated-browser-style', $css, array(), $this->libVersion);
        wp_enqueue_script('tp-outdated-browser-js', $js, array('jquery'), $this->libVersion);
    }

    /**
     * Build HTML markup
     */
    public function add_html() {
        ?>
        <!-- Outdated Browser Alert -->
        <div id="outdated"></div>
        <?php
    }

    /**
     * Init JS script
     */
    public function init_js() {
        $template = $this->pluginPath.'lang/'.$this->pluginLang.'.html';
        ?>
        <!-- Outdated Browser script -->
        <script>
            jQuery(document).ready(function () {
                outdatedBrowser({
                    bgColor: '#f25648',
                    color: '#ffffff',
                    lowerThan: 'transform',
                    languagePath: '<?php echo $template; ?>'
                });
            });
        </script>
        <?php
    }

}
// END Class

/**
 * Init the __construct
 */
add_action("init", "tribalpixelOutdatedBrowserInit", 1);

function tribalpixelOutdatedBrowserInit() {
    global $tribalpixelOutdatedBrowser;
    $tribalpixelOutdatedBrowser = new tribalpixelOutdatedBrowser();
}

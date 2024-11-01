<?php
/*
Plugin Name: WeChef
Description: Intégration du module de réservation WeChef sur votre site WordPress
Version: 1.0.0
Author: Liziweb
Author URI: https://liziweb.com/
Text Domain: wechef
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die();

class WeChef{
    public function __construct(){
        include_once(plugin_dir_path(__FILE__)."Settings.php");
        include_once(plugin_dir_path(__FILE__)."Floating.php");
    }
}
new WeChef();

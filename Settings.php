<?php
defined( 'ABSPATH' ) or die();
class WeChef_settings{
    public function  __construct(){
        add_action('admin_menu', array($this, 'wechef_add_admin_menu'), 20);
        add_action('admin_init', array($this, 'wechef_register_settings'));
    }
    public function wechef_register_settings(){
        register_setting('wechef_settings', 'wechef_id');
        register_setting('wechef_settings', 'wechef_bgcolor');
        register_setting('wechef_settings', 'wechef_txtcolor');
        register_setting('wechef_settings', 'wechef_font');
    }
    public function wechef_add_admin_menu(){
        add_menu_page('WeChef', 'WeChef', 'manage_options', 'wechef', array($this, 'wechef_settings'));
    }
    public function wechef_settings(){
        echo '<h1>'.get_admin_page_title().'</h1>';
        ?>
        <form method="post" action="options.php">
            <?php settings_fields('wechef_settings') ?>
            <label><?php _e("ID du restaurant : ", "wechef"); ?></label>
            <input type="text" name="wechef_id" value="<?php echo get_option('wechef_id')?>"/><br/><br/>
            <label><?php _e("Couleur de fond du bandeau : ", "wechef"); ?></label>
            <input type="text" name="wechef_bgcolor" value="<?php echo get_option('wechef_bgcolor', '#000000')?>"/><br/><br/>
            <label><?php _e("Couleur du texte du bandeau : ", "wechef"); ?></label>
            <input type="text" name="wechef_txtcolor" value="<?php echo get_option('wechef_txtcolor', '#ffffff')?>"/><br/><br/>
            <label><?php _e("Police d'écriture : ", "wechef"); ?></label>
            <input type="text" name="wechef_font" value="<?php echo get_option('wechef_font', 'inherit')?>"/><br/><br/>
            <?php submit_button(); ?>
        </form>
        <?php
    }
}

new WeChef_settings();

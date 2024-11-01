<?php
defined( 'ABSPATH' ) or die();
class WeChef_floating{
    public function __construct(){
        add_action('wp_footer', array($this, "wechef_floating"));
    }
    function wechef_floating() { ?>
            <style>
                .wechef{
                    position: fixed;
                    bottom: 10px;
                    right: 10px;
                    z-index: 16777271;
                    max-width: 500px;
                    min-height: 50px;
                    overflow: hidden;
                    width: calc(100vw - 35px);
                    margin-left: 10px;
                }
                .wechef__top{
                    height: 50px;
                    background: <?php echo !empty(get_option('wechef_bgcolor', '#000000'))?get_option('wechef_bgcolor', '#000000'):'#000000'; ?>;
                    padding: 14px;
                    cursor: pointer;
                    position: relative;
                    color: <?php echo !empty(get_option('wechef_txtcolor', '#ffffff'))?get_option('wechef_txtcolor', '#ffffff'):'#ffffff' ; ?>;
                    font-size: 16px;
                    text-transform: uppercase;
                    font-family: <?php echo !empty(get_option('wechef_font', 'inherit'))?get_option('wechef_font', 'inherit'):'inherit' ; ?>;
                }
                .wechef__content{
                    display: none;
                    border: 2px solid <?php echo !empty(get_option('wechef_bgcolor', '#000000'))?get_option('wechef_bgcolor', '#000000'):'#000000' ; ?>;
                    background: white;
                    max-height: calc(100vh - 100px);
                    height: 832px;
                    text-align: center;
                }
                .wechef__content iframe{
                  width:100%;
                  height: 100%;
                  margin-bottom: 0;
                }
            </style>
        <?php
        $json = wp_remote_get("https://wechef.app/wp-json/wp/v2/restaurants/".get_option('wechef_id'));
        if($json["response"]["code"] == "200"){
                $json = json_decode($json["body"]);
                $domains = explode(";", $json->domains);
                if(in_array($_SERVER['SERVER_NAME'], $domains)){
                    /* Est-il activé ? */
                    if($json->activation){ ?>
                        <div class="wechef">
                            <div class="wechef__top">
                                <?php _e("Réservez une table maintenant !", "wechef"); ?>
                            </div>
                            <div class="wechef__content">
                                <iframe frameborder="0" src="https://wechef.app/restaurant/<?php echo get_option('wechef_id'); ?>/?txtcolor=<?php echo urlencode(get_option('wechef_txtcolor', '#ffffff'))."&bgcolor=".urlencode(get_option('wechef_bgcolor', '#000000')); ?>&displayTitle=no"></iframe>
                            </div>
                        </div>
                        <script>
                            jQuery(document).ready(function(){
                                jQuery(".wechef__top").click(function(e){
                                    e.preventDefault();
                                    jQuery(".wechef__content").slideToggle();
                                })
                            });
                        </script>
                    <?php }else{
                    $current_user = wp_get_current_user();
                    if($current_user->roles[0] == "administrator"){ ?>
                        <div class="wechef">
                            <div class="wechef__top">
                                <?php _e("Ce restaurant est désactivé !", "wechef"); ?>
                            </div>
                        </div>
                    <?php }
                }
            }else{
                $current_user = wp_get_current_user();
                if($current_user->roles[0] == "administrator"){ ?>
                   <div class="wechef">
                        <div class="wechef__top">
                            <?php _e("Ce domaine n'est pas autorisé !", "wechef"); ?>
                        </div>
                    </div>
                <?php }
            }
        }else{
            $current_user = wp_get_current_user();
            if($current_user->roles[0] == "administrator"){ ?>
                <div class="wechef">
                    <div class="wechef__top">
                        <?php _e("L'ID du restaurant est invalide !", "wechef"); ?>
                    </div>
                </div>
            <?php }
        } ?>
    <?php }

}

new WeChef_floating();

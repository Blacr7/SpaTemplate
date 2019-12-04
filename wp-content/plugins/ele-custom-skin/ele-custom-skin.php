<?php
/*
 * Plugin Name: Ele Custom Skin
 * Version: 1.3.9
 * Description: Elementor Custom Skin for Posts and Archive Posts. You can create a skin as you want.
 * Plugin URI: https://dudaster.com
 * Author: Dudaster.com
 * Author URI: https://dudaster.com
 * Text Domain: ele-custom-skin
 * Domain Path: /languages
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELECS_DIR', plugin_dir_path( __FILE__ ));
define( 'ELECS_NAME', plugin_basename( __FILE__ ));
define( 'ELECS_URL', plugin_dir_url( __FILE__ ));
define ('ELECS_VER','1.3.9');

include_once ELECS_DIR.'includes/ecs-notices.php';
include_once ELECS_DIR.'includes/ecs-dependencies.php';
include_once ELECS_DIR.'includes/enqueue-styles.php';

//check if Elementor is installed

if (ecs_dependencies()) {
  add_action( 'elementor_pro/init', 'elecs_elementor_init' );
  function elecs_elementor_init(){
      //load templates types

    //require_once ELECS_DIR.'theme-builder/init.php';
    require_once ELECS_DIR.'theme-builder/init.php';

  }

  add_action('elementor/widgets/widgets_registered','elecs_add_skins');
  function elecs_add_skins(){
    require_once ELECS_DIR.'skins/skin-custom.php';
  }


  include_once ELECS_DIR.'includes/pro-features.php';

  // dynamic background fix
  require_once ELECS_DIR.'includes/background-fix.php';
  require_once ELECS_DIR.'includes/flip-box-fix.php';
  
  add_action('init', 'ecs_check_for_notification');
  
} else {
    $notification = new Ecs_Notice(__( '<b>Ele Custom Skin</b> needs <b>Elementor</b> and <b>Elementor Pro</b> to work. Make sure you have them <b>both</b> installed.', 'ele-custom-skin' ));
    $notification->set_type('error');
    $notification->show();
}

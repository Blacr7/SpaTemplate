<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// dynamic background fix
function ECS_set_bg_element_flip_box( \Elementor\Element_Base $element ) {
  global $ecs_render_loop;
 
  if(!$ecs_render_loop || "flip-box" != $element->get_name())
    return; // only act inside loop
  list($PostID,$LoopID)=explode(",",$ecs_render_loop);
  $ElementID = $element->get_ID();
  $dynamic_settings = $element->get_settings( '__dynamic__' );
  $all_controls = $element->get_controls();
  $all_controls = isset($all_controls) ? $all_controls : []; $dynamic_settings = isset($dynamic_settings) ? $dynamic_settings : [];
  $controls = array_intersect_key( $all_controls, $dynamic_settings );
  $settings = $element->parse_dynamic_settings( $dynamic_settings, $controls);
  //print_r($settings);
  /* start custom css */
  $css_rules['flip-box']['normal'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID} .elementor-flip-box__front";
  $css_rules['flip-box']['hover']  = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID} .elementor-flip-box__back";
  
  $bg['normal']= isset($settings["background_a_image"]["url"]) ? $settings["background_a_image"]["url"] :"";
  $bg['hover']= isset($settings["background_b_image"]["url"]) ? $settings["background_b_image"]["url"] : "";

  $key_element = 'flip-box';
  
 $ECS_css="";
  foreach($css_rules[$key_element] as $key => $value){
    $ECS_css.=$bg[$key] ? $css_rules[$key_element][$key]." {background-image:url(".$bg[$key].");} " : "";
  }
  
   echo $ECS_css ? "<style>".$ECS_css."</style>" :"";
  /* end custom css*/
}

add_action( 'elementor/frontend/widget/before_render', 'ECS_set_bg_element_flip_box' );

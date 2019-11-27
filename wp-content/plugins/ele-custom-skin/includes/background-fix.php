<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// dynamic background fix
function ECS_set_bg_element( \Elementor\Element_Base $element ) {
  global $ecs_render_loop;
  if(!$ecs_render_loop)
    return; // only act inside loop
  list($PostID,$LoopID)=explode(",",$ecs_render_loop);
  $ElementID = $element->get_ID();
  $dynamic_settings = $element->get_settings( '__dynamic__' );
  $all_controls = $element->get_controls();
  $all_controls = isset($all_controls) ? $all_controls : []; $dynamic_settings = isset($dynamic_settings) ? $dynamic_settings : [];
  $controls = array_intersect_key( $all_controls, $dynamic_settings );
  $settings = $element->parse_dynamic_settings( $dynamic_settings, $controls);
  
  /* start custom css */
  $css_rules['section']['normal'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}:not(.elementor-motion-effects-element-type-background), #post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID} > .elementor-motion-effects-container > .elementor-motion-effects-layer";
  $css_rules['section']['hover'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}:hover";
  $css_rules['section']['overlay'] ="#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID} > .elementor-background-overlay";
  $css_rules['section']['overlay_hover']="#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}:hover > .elementor-background-overlay";
  $css_rules['column']['normal'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}:not(.elementor-motion-effects-element-type-background) > .elementor-element-populated, #post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID} > .elementor-column-wrap > .elementor-motion-effects-container > .elementor-motion-effects-layer";
  $css_rules['column']['hover'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}:hover > .elementor-element-populated";
  $css_rules['column']['overlay'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID} > .elementor-element-populated > .elementor-background-overlay";
  $css_rules['column']['overlay_hover'] = "#post-{$PostID} .elementor-{$LoopID} .elementor-element.elementor-element-{$ElementID}:hover > .elementor-element-populated > .elementor-background-overlay";
  
  $bg['normal']= isset($settings["background_image"]["url"]) ? $settings["background_image"]["url"] : (isset($settings["_background_image"]["url"]) ? $settings["_background_image"]["url"] : "");
  $bg['hover']= isset($settings["background_hover_image"]["url"]) ? $settings["background_hover_image"]["url"] : (isset($settings["_background_hover_image"]["url"]) ? $settings["_background_hover_image"]["url"] : "");
  $bg['overlay']= isset($settings["background_overlay_image"]["url"]) ? $settings["background_overlay_image"]["url"] : (isset($settings["_background_overlay_image"]["url"]) ? $settings["_background_overlay_image"]["url"] : "");
  $bg['overlay_hover']= isset($settings["background_overlay_hover_image"]["url"]) ? $settings["background_overlay_hover_image"]["url"] : (isset($settings["_background_overlay_hover_image"]["url"]) ? $settings["_background_overlay_hover_image"]["url"] : "");
  
  $key_element = $element->get_name()=='section' ? "section" : "column";
  
 $ECS_css="";
  foreach($css_rules[$key_element] as $key => $value){
    $ECS_css.=$bg[$key] ? $css_rules[$key_element][$key]." {background-image:url(".$bg[$key].");} " : "";
  }
  
   echo $ECS_css ? "<style>".$ECS_css."</style>" :"";
  /* end custom css*/
}

add_action( 'elementor/frontend/section/before_render', 'ECS_set_bg_element' );
add_action( 'elementor/frontend/column/before_render', 'ECS_set_bg_element' );

//keep track of index

add_action( 'elementor/frontend/widget/before_render', function ( \Elementor\Element_Base $element ) {
  global $ecs_index;
	if ( 'posts' === $element->get_name() ||  'archive-posts' === $element->get_name()) {
		$ecs_index=0;
	}
} );
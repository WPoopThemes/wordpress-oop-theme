<?php 
namespace Classes\Utils;

/*
###########################
# USAGE:

use Classes\Utils\Shortcodes as ShortcodesFactory;

$shortcodes_factory = new ShortcodesFactory();

$shortcodes_factory->register_self_closing_shortcode(array(
  'tag' => '',
  'cb' => function($atts){
    extract(shortcode_atts(array(
      '$width' => 300, 
      'height' => 400), $atts)
    );
    return '<img src="https://lorempixel.com/'. $width . '/'. $height . '" />';
  } 
));

returns -> [picture width="500" height="500"] OR [picture]

----------------

# $atts [optional], do the same as above to add $atts.

$shortcodes_factory->register_enclosing_shortcode(array(
  'tag' => '',
  'cb' => function( $atts, $content = null ) {
    return '<span class="caption">' . $content . '</span>';
  }
));

returns -> [caption]My Caption[/caption]

###########################
*/

  class Shortcodes {

    public function __construct(){

    }

    public function register_enclosing_shortcode($params){
      add_shortcode($params['tag'], $params['cb']);
    }

    public function register_self_closing_shortcode($params){
      add_shortcode($params['tag'], $params['cb']);
    }

  }
?>
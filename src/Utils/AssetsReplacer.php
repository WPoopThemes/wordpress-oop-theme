<?php
namespace Classes\Utils;

use WPTheme\Controllers\ThemeController;

/**
 * Removes custom styles and scripts registered by 3rd parties plugins, themes or whatever
 * any style or script that has to be removed, has to be placed into $list, by specifying its id, 
 * that can be gathered by inspectig the DOM.
 */

class AssetsReplacer extends ThemeController
{

    public $list;

    //'cpapp-calendarstyle-css' => $this->assets_uri ."_src/lib/styles/jqueryui-calendar-custom.css"

    public function register()
    {
        add_action('wp_enqueue_scripts', array($this, 'set'));
        add_action('style_loader_tag', array($this,'replace'), 99999, 1);
    } 

    public function replace($src) {
        foreach($this->list as $id){
            if(strpos($src,"id='". $id. "'") != false){
                $src = "";
            }
        }

        return $src;
    } 

    public function set()
    {
        foreach($this->list as $id => $asset){
            if(empty($asset)) continue;
            wp_enqueue_style($id . '_replacer', $asset, false, false);
        }
    }

    public function set_files(array $list){
        $this->list = $list;

        return $this;
    }

}

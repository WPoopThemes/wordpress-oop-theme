<?php
/*

Questo modulo si occupa di gestire l'inclusione di custom styles in sostituzione di style già presenti nel DOM.
Fornisce la possibilità di togliere altri styles inclusi in wp da parte di terze parti es. plugin
Gli elementi da rimuovere vanno specificati tramite l'id (nell'array $listReplacerStylesAssets) di riferimento specificato in fase di enqueuing dei files.
Nell'Array $listReplacerStylesAssets è possibile specificare il VALORE ( la chiave è l'ID da togliere) dello script custom da incluedere al posto di quello eliminato.

*/ 
?>
<?php
namespace Classes\Utils;

class CustomAssetsReplacer{

    private $listReplacerStylesAssets = array(
        'cpapp-calendarstyle-css' => ASSETS_URI."_src/lib/styles/jqueryui-calendar-custom.css",
    );

    public function __construct(){
        add_action('wp_enqueue_scripts', array($this, 'setterStyles'));
        add_action('style_loader_tag', array($this,'replacer'),99999,1);
    } 

    public function replacer($src) {
        foreach($this->listReplacerStylesAssets as $id => $replaceAssets){
            if(strpos($src,"id='".$id."'")!=false){
            $src = "";
            }
        }

        return $src;
    } 

    public function setterStyles() {
        foreach($this->listReplacerStylesAssets as $id => $replaceAsset){
            if(empty($replaceAsset)) continue;
            wp_enqueue_style($id."_customstylereplacer", $replaceAsset, false, false);
        }
    } 

}

?>
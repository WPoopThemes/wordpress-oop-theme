<?php 
namespace Classes\Core;
class Modules {
    protected $directoryModules = LIB_ROOT."classes/modules";

    public function __construct(){
        global $tmp_pathSplAutoloader;
        global $tmp_realFileName;
        
        spl_autoload_register(function ($class) {
            global $tmp_pathSplAutoloader;
            global $tmp_realFileName;
            try{
            //echo 'modules/'.$tmp_pathSplAutoloader.'/'. $tmp_realFileName .'/'. $class .'.module.php<br/>';
            @include 'modules/'.$tmp_pathSplAutoloader.'/'. $tmp_realFileName .'/'. $class .'.module.php';
            }catch(Exception $e){
                var_dump($e);
            }
        });
        if ($dh = opendir($this->directoryModules)) {
            //echo "DIR ----> ".$this->directoryModules."<br/>"; 
            //var_dump($dh);
            while (($dir = readdir($dh)) !== false) {
                //echo "DIR CHECK ----> ".$dir."<br/>"; 
                
                if(array_search($dir, unserialize(MODULES_DIR))!==false){
                    if($dir == '..' || $dir == '.'){continue;}
                    try{
                        if ($dhModules = opendir($this->directoryModules."/".$dir)) {
                            //echo "DIR FIGLIA ----> ".$this->directoryModules."/".$dir."<br/>"; 
                            while (($file = readdir($dhModules)) !== false) {
                                    if($file == '..' || $file == '.'){continue;}
                                        try{
                                            $tmp_pathSplAutoloader=$dir;
                                            if(array_search($file, unserialize(DISABLED_MODULES))===false){

                                                $tmp_realFileName = $file; //memorizzo il nome reale del file prima di controllare se siano stati inseriti valori di priorità
                                                $nameClass = $file;
                                                $priorityCheck = explode("_",$nameClass); //la parte prima di underscore identifica la priorità del modulo

                                                    if(count($priorityCheck)>1){
                                                        $nameClass=str_replace($priorityCheck[0]."_","",$nameClass); //elimino tutta la parte relativa alla priorità dal path 
                                                    }

                                                if(class_exists($nameClass)){ new $nameClass(); } 
                                            }
                                        }catch(Exception $e){
                                            var_dump($e);
                                        }
                            }
                            closedir($dhModules);
                        }
                        //new $file();
                    }catch(Exception $e){
                        var_dump($e);
                    }
                }
                //echo $dir."<br/>"; 
            }
            closedir($dh);
        }
    }
}
?>
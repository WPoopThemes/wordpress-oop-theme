<?php 
namespace Classes\Utils;

class downloadShield {
    public function __construct(){
        add_filter('download_shield', array($this, 'download_shield'), 10);
    }

    public function download_shield(){
        global $wpdb;
        $redirect_to = home_url('/');
        $redirect_to_no_permission = $redirect_to;  
                
        $wp_referer = wp_get_referer();
        $parsedReferer = parse_url($wp_referer);
        // Checks for a page based on HTTP_REFERER -> $_SERVER
        $postID = url_to_postid($wp_referer);
        $tokenWG = $_GET["_tokenwg"];

        if(!empty($tokenWG)){
            $hash = md5("W3bt4!L=r".date("d-m-Y"));
            if(strcmp($hash,$tokenWG) == 0){
                // Il codice è corretto quindi...
                $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
                exit;
            }
            
        }
        //Direct download if admin
        if(is_user_logged_in()){
            $data = get_currentuserinfo();
            $role = $data->roles[0];
            if($role === 'administrator'){
                $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
                exit;
            }
        }
        
        //No download if no referer found
        if(empty($wp_referer)){
            wp_redirect($redirect_to);
            exit;
        }
        
		if(empty($postID)){
            //Check if page exists
            $page_path     = rawurlencode( urldecode( $wp_referer ) );
            $page_path     = str_replace( '%2F', '/', $page_path );
            $page_path     = str_replace( '%20', ' ', $page_path );
            $parts         = explode( '/', trim( $page_path, '/' ) );
            $parts         = array_map( 'sanitize_title_for_query', $parts );
            $escaped_parts = esc_sql( $parts );
            $in_string = "'" . implode( "','", $escaped_parts ) . "'";
            $sql = "
            SELECT ID
            FROM $wpdb->posts
            WHERE post_name IN ($in_string) AND post_type = 'page' AND post_status = 'publish' LIMIT 1";
        
            $postID = $wpdb->get_var($wpdb->prepare( $sql ));

        }
		
        $postData = get_post($postID);
        $post_type = get_post_type($postID);
        
        if((int)$postID !== 0){

            global $current_user;
            get_currentuserinfo();
            $user_meta = get_userdata($current_user->ID);
            $user_roles = $user_meta->roles;
            $post_visibility = get_field('post_visibility_role_based', $postID);

            $file_autor_exists_with_restrictions = false;
            $file_documenti_exists_with_restrictions = false;

            if($post_type === 'aziende-federate'){

                /*CHECK CONTENUTO AUTORIZZAZIONE */
                $file_autor_exists_with_restrictions = $this->documentCheck(
                    'wp_postmeta', 
                    $postID, 
                    'campi_azienda_autorizzazioni_%_campi_azienda_autorizzazioni_autorizzazione', 
                    $_SERVER['REQUEST_URI'],
                    true
                );

                /*se non sei loggato e provi a scaricare un file autorizzazioni vai in home page */
                if(!empty($file_autor_exists_with_restrictions)){
                    wp_redirect($redirect_to_no_permission);
                    exit;
                }

                /*END */
                
                /*CHECK CONTENUTO DOCUMENTI START */
                        // $file_documenti_exists_with_restrictions = $this->documentCheck(
                        //     'wp_postmeta', 
                        //     $postID, 
                        //     'campi_azienda_documenti_%_campi_azienda_documenti_documento', 
                        //     $_SERVER['REQUEST_URI'],
                        //     true
                        // );

                        // if(!empty($file_documenti_exists_with_restrictions)){
                        //     //Se la richiesta è da parte di un utente loggato per un documento azienda federata
                        //     //scarica il file
                        //     $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
                        // }
                /*END */

                // Contenuto senza restrizioni ma inserito all'interno del post-type aziende federate
                $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);

            } 
            
            /*CONTROLLO FILE CON RESTRIZIONE - FIELDGROUP ACF START */
            

                $file_exists_with_restrictions = false;
                $documentExists = $this->documentCheck(
                    'wp_postmeta', 
                    $postID, 
                    'aggiungi_allegati_%_allegato_file', 
                    $_SERVER['REQUEST_URI'],
                    true
                );

                if($documentExists > 0){

                    $file_exists_with_restrictions = true;

                }

                if($file_exists_with_restrictions){

                    switch($post_visibility){
                        case 'logged':

                            if(is_user_logged_in()){

                                $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);

                            } else {

                                wp_redirect($redirect_to_no_permission);
                                exit;
                            }

                        break;
                        case 'logged_specific':

                            if(is_user_logged_in()){

                                $post_visibility_by_role = get_field('ruoli_disponibili_visibilita_post', $postID);
                                $post_visibility_by_role_admin = array();
                                $post_visibility_by_role_admin['value'] = 'administrator';
                                $post_visibility_by_role_admin['label'] = 'Admin';
                                array_push($post_visibility_by_role_admin, $post_visibility_by_role);
                        
                                $can_read_post = $this->in_array_r($user_roles[0], $post_visibility_by_role_admin);

                                if($can_read_post){

                                    $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);

                                } else if (!$can_read_post){

                                    wp_redirect($redirect_to_no_permission);
                                    exit;

                                }

                            }

                        break;
                        default:
                            $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
                        break;

                    }

                } else {

                    // contenuto senza restrizioni
                    $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);

                }

            /*CONTROLLO FILE CON RESTRIZIONE - FIELDGROUP ACF END */

        } else {
            /*ultimo check se la richiesta è derivata da un archivio */
            $checkUrl = downloadShield::checkArchiveUrl($wp_referer);
                if(!empty($checkUrl)){
                    $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
                }
            /*END*/
            wp_redirect($redirect_to);
            exit;
        }
    }


    public static function checkArchiveUrl($referer){

        // $rules = get_option( 'rewrite_rules' );
        // if ( ! isset( $rules['(project)/(\d*)$'] ) ) { 
        //     global $wp_rewrite; $wp_rewrite->flush_rules();
        // }


        // var_dump(@preg_match('aziende-federate/?$', 'aziende-federate/'));
        // var_dump($rules);
        $result = false;
        //archivio aziende federate
        if(strpos($referer,'/aziende-federate/')!==false){
            $result = true;
        }

        if(strpos($referer,'/category/')!==false){
            $result = true;
        }

        if(strpos($referer,'/media-library/')!==false){
            $result = true;
        }

        return $result;
    }


    public function downloadFile($file){
        $filePath = explode("?",$file);
        $file = trim($filePath[0]);
        if(file_exists($file)){
            $filename = substr($file, strrpos($file, '/' )+1);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

    }

    public function in_array_r($needle, $haystack, $strict = false) {

        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
            return true;
            }
        }
        return false;

    }

    public function documentCheck($metaType, $postID, $metaKey, $guid, $outputValue=false){

        global $wpdb;
        $sqlDocumentCheck = "
            SELECT COUNT(pmeta.meta_value) AS Total
            FROM `{$metaType}` AS pmeta
            LEFT JOIN `wp_posts` AS pposts ON pmeta.meta_value = ID
            WHERE 
            pmeta.post_id = {$postID}
            AND pmeta.meta_key LIKE '{$metaKey}'
            AND pposts.guid = 'http://aiad.local/content{$guid}' LIMIT 1
        ";

        $result = $wpdb->get_var( $wpdb->prepare($sqlDocumentCheck) );

        
        if(empty($outputValue)){
            if($result > 0){
                $this->downloadFile($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
            }
            exit;
        }else{
            return $result;
        }

    }

}

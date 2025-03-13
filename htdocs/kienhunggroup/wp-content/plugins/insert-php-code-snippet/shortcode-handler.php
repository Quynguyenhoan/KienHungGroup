<?php
if ( ! defined( 'ABSPATH' ) )
    exit;
global $wpdb;
add_shortcode('xyz-ips','xyz_ips_display_content');
function xyz_ips_display_content($xyz_snippet_name){
    global $wpdb;
    if (is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ))
  	{
          return ''; // Do not execute the shortcode in the admin area
    }
    if(is_array($xyz_snippet_name)&& isset($xyz_snippet_name['snippet'])){
        $snippet_name = $xyz_snippet_name['snippet'];
        $query = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_ips_short_code WHERE title=%s" ,$snippet_name));
        if(!empty($query))//if(count($query)>0)
        {
            foreach ($query as $sippetdetails){
                if($sippetdetails->status==1){
                  /*  if(is_numeric(ini_get('output_buffering'))){
                        $tmp=ob_get_contents();
                        if(strlen($tmp)>0)
                          ob_clean();*/
                        ob_start();
                        $content_to_eval=$sippetdetails->content;

/***** to handle old codes : start *****/

if(get_option('xyz_ips_auto_insert')==1){
    $xyz_ips_content_start='<?php';
    $new_line="\r\n";
    $xyz_ips_content_end='?>';

    if (stripos($content_to_eval, '<?php') !== false)
        $tag_start_position=stripos($content_to_eval,'<?php');
    else
        $tag_start_position="-1";

    if (stripos($content_to_eval, '?>') !== false)
        $tag_end_position=stripos($content_to_eval,'?>');
    else
        $tag_end_position="-1";

    if(stripos($content_to_eval, '<?php') === false && stripos($content_to_eval, '?>') === false)
    {
        $content_to_eval=$xyz_ips_content_start.$new_line.$content_to_eval;
    }
    else if(stripos($content_to_eval, '<?php') !== false)
    {
        if($tag_start_position>=0 && $tag_end_position>=0 && $tag_start_position>$tag_end_position)
        {
            $content_to_eval=$xyz_ips_content_start.$new_line.$content_to_eval;
        }
    }
    else if(stripos($content_to_eval, '<?php') === false)
    {
        if (stripos($content_to_eval, '?>') !== false)
        {
            $content_to_eval=$xyz_ips_content_start.$new_line.$content_to_eval;
        }
    }
    $content_to_eval='?>'.$content_to_eval;
}

/***** to handle old codes : end *****/
else{
    if(substr(trim($content_to_eval), 0,5)=='<?php')
        $content_to_eval='?>'.$content_to_eval;
}


$exception_occur=0;
$exception_msg="";

      try {


          eval($content_to_eval);
      } catch (Throwable $e) { // For PHP 7 and later
          $exception_occur = 1;
          $exception_msg = $e->getMessage();
    }
      catch (Exception $e) { // For PHP 5
        $exception_occur = 1;
        $exception_msg = $e->getMessage();
    }



                        if($exception_occur==1) {

        						//	global $post;
        	         				 //  $post_slug = $post->post_name;

        							//if($post_slug!="xyz-ics-preview-page" && !is_customize_preview())
                      {

        								if(get_option('xyz_ips_exception_email')!="0" && get_option('xyz_ips_exception_email')!="" && get_option('xyz_ips_auto_exception')==1)
                        {
            									$email=get_option('xyz_ips_exception_email');
            									$headers= "Content-type: text/html";
            									$subject="Exception Report";
        									$message="Hi,<br>An exception occurred while running one of the snippet.The snippet name is ".$snippet_name;
        									$message.=".<br>Exception details are given below : <br>";
            									$message.=$exception_msg;
            									wp_mail($email, $subject, $message,$headers);
            								}
            							}
            						}

                        $xyz_em_content = ob_get_contents();
                       // ob_clean();
                        ob_end_clean();
                         return $xyz_em_content;
                  /*  }
                    else{
                        eval($sippetdetails->content);
                    }*/
                }
                else{
                    return '';
                }
                break;
            }
        }
        else{
            return '';
        }
    }
}
add_filter('widget_text', 'do_shortcode'); // to run shortcodes in text widgets

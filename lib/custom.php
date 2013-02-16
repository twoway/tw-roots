<?php

// Custom functions by TwoWay


/*-----------------------------------------------------------------------------------*/
/* TWOWAY REPLACE CLASS OF 
IMAGES DISPLAYED FOR 'wp_get_attachment_link' SINGLE ISSUE PAGE- START
/*-----------------------------------------------------------------------------------*/
            //Replace class for issue images
            function add_class_attachment_link_a($html){
              $postid = get_the_ID();
              $html = str_replace('<a','<a class="issue_images"',$html);
              return $html;
            }
          add_filter('wp_get_attachment_link','add_class_attachment_link_a',10,1);

        function add_class_attachment_link_img($html){
            $postid = get_the_ID();
            $html = str_replace('<img','<img class="img-polaroid"',$html);
            return $html;
            }
        add_filter('wp_get_attachment_link','add_class_attachment_link_img',10,1);

      
/*-----------------------------------------------------------------------------------*/
/* TWOWAY REPLACE CLASS... - END
/*-----------------------------------------------------------------------------------*/





add_filter( 'wp_mail_from', 'twoway_mail_from' );
function twoway_mail_from( $email )
{
    return 'automail@ignescosba.se';
}

add_filter( 'wp_mail_from_name', 'twoway_mail_from_name' );
function twoway_mail_from_name( $name )
{
    return 'Ignesco SBA - Automail - Svara ej';
}

/*-----------------------------------------------------------------------------------*/
/* TWOWAY DISABLE ACF CSS - START
/*-----------------------------------------------------------------------------------*/

//add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 
function my_deregister_styles() {
  wp_deregister_style( 'wp-admin' );
}

/*-----------------------------------------------------------------------------------*/
/* TWOWAY DISABLE ACF CSS - END
/*-----------------------------------------------------------------------------------*/

/* This function attaches the image to the post in the database, add it to functions.php */

function insert_attachment($file_handler,$post_id,$setthumb='false') {

  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );

  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
  return $attach_id;
}
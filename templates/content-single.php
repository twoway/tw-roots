<?php


// 'new_upload' - Handling of single or multiple files
global $post;
 
if ( $_FILES ) {
$files = $_FILES['upload_attachment'];
foreach ($files['name'] as $key => $value) {
if ($files['name'][$key]) {
$file = array(
'name' => $files['name'][$key],
'type' => $files['type'][$key],
'tmp_name' => $files['tmp_name'][$key],
'error' => $files['error'][$key],
'size' => $files['size'][$key]
);
 
$_FILES = array("upload_attachment" => $file);
 
foreach ($_FILES as $file => $array) {
$newupload = insert_attachment($file,$post->ID);
}
}
}
} 

?>

<?php // Deleting image by setting the id to empty string


if ( $_POST ) {
//$image_empty_string = "dsdsds";
$image_deleted = $_POST['delete_image'];
//echo 'Variable value of $image_deleted: ' . $image_deleted ;
$acf_value = $image_deleted;
//echo '</br>';
//echo 'AFC value: '.$acf_value;
update_field( "field_1", $acf_value );

echo '</br>';

	if ($image_deleted == "deleted"){
	//echo "deleted";
	}
	else {
	//echo "not text deleted";
	}

}
	
else {
//echo 'AFC value: '.$acf_value;
}


?>


<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php //get_template_part('templates/entry-meta'); ?>
    </header>
      <div class="entry-content">
      <?php //the_content(); ?>
      
	  <!--
    <h3>Image ACF field</h3>
	  <h5>Using functions update_field() and get_field() </h5>
	   -->
	  <?php //TwoWay populate ACF image field if image is not set to "deleted"
		
			$argsThumb = array(
				'order'           => 'ASC',
				'post_type'      => 'attachment',
				'post_parent'    => $post->ID,
				'post_mime_type' => 'image',
				'post_status'    => null,
				'numberposts' 	=> -1 //In this case we only allow 1 attachment to populate ACF image field
			);
			$attachments = get_posts($argsThumb);
			if ($attachments) {
				foreach ($attachments as $attachment) {
					$acf_value = $attachment->ID;
					//echo $acf_value;
					update_field( "field_1", $acf_value );
					$image_id = get_field( "image" ); 
					//echo wp_get_attachment_link( $image_id, thumbnail);
				}
			}
			?>
			
			<?php echo wp_get_attachment_link( $image_id, thumbnail);?>
	  
     <!-- TwoWay added -->
     <!--
      <img src="<?php the_field('image'); ?>" alt="" />

      <img src="<?php the_field('file'); ?>" alt="" />
      -->
      <!--
      <h3>Documents (get_field) repeater field</h3>
        <div class="bs-docs-example">
          
              <?php
              // using normal array
 
                //$rows = get_field('object_documents');
                echo "";
                //print_r($rows);
                echo "";
                //if($rows)
                {
                  echo '<ul>';
                 
                 // foreach($rows as $row)
                  {

                   // echo '<li>sub_field_1 = ' . $row['object_document_file'] . ', sub_field_2 = ' . $row['object_document_do_not_show_in_controls'] .', etc</li>';
                  }
                 
                  echo '</ul>';
                }
                ?>
                <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="document">Handling</th>
                    <th class="document-description">Beskrivning</th>
                    <th class="document">Visas i kontroll</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                // or has_sub_field + the_sub_field
                if(get_field('object_documents')): ?>
                 
                  
                 
                  <?php while(has_sub_field('object_documents')): ?>

                  <tr>

                    <td class="document"><a target="_blank" href="<?php the_sub_field('object_document_file'); ?>">Klicka här</a></td>
                    <td class="document-description"><?php the_sub_field('object_document_description'); ?></td>
                    <td class="document-show"><?php the_sub_field('object_document_do_not_show_in_controls'); ?></td>  
                 
                 </tr>
                  <?php endwhile; ?>
                 
                  
                 
                <?php endif; ?>

            </tbody>
          </table>
        </div>
		-->
		
		<hr>
    <!--
		<h5>Custom form for uploading image and populating image field</h5>
		<p>The last uploaded image populates ACF image field (attachemt_ID) is updated but attachemt image file is not deleted and info is still in DB.</p>
		-->
		Ladda upp bild : <form action="#" method="post" enctype="multipart/form-data"><input class="upload-attachment" type="file" accept="image/*" name="upload_attachment[]" /> 
    <p>
    <br />
    <input class="upload-attachment-submit btn btn-success" type="submit" value="Ladda upp" /></form>
    </p>
		<div class="alert alert-info">
      <strong>Tänk på att</strong><p>Om du använder telefon eller surfplatta kan det ta upp till 30sek innan uppladding är klar</p>
      </div>


    
    <!--
		Delete image: <form action="#" method="post"><input type="hidden" name="delete_image" value="deleted"/><input type="submit" value="Delete image"/></form>
    -->
  
  <!--

	<hr>
		<h2>ACF front end native form for editing custom fields</h2>
	
  -->
     <?php// acf_form() ?>
  <hr>
    </div>
    <footer>
      <?php //wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
      <?php //the_tags('<ul class="entry-tags"><li>','</li><li>','</li></ul>'); ?>
    </footer>
    <?php //comments_template('/templates/comments.php'); ?>
  </article>

  

<?php endwhile; ?>

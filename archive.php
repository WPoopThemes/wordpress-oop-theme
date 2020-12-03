<?php 
	get_header();
	//Removes Archive: from the archive title
	$archive_title = explode(':', get_the_archive_title());
	$title =  $archive_title[1];
?>

<?php
    if ( have_posts() ) :

      the_archive_title( '<h1>', '</h1>' );
      the_archive_description( '<div>', '</div>' );
      
      while ( have_posts() ) :
        
				the_post();
				get_template_part( '/lib/template-parts/content/archive', 'page');

			endwhile;

		else :

			get_template_part( '/lib/template-parts/content', 'none' );

		endif;
		?>

<?php 
  get_footer();
?>
<?php 
  get_header();
?>

<p>qui</p>

<?php
    if ( have_posts() ) :
      
      while ( have_posts() ) :
        
				the_post();
				get_template_part( '/lib/template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( '/lib/template-parts/content', 'none' );

    endif;
?>

<?php 
  get_footer();
?>
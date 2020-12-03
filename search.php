<?php
get_header();
?>

<?php
    if ( have_posts() ) :

      printf( esc_html__( 'Search Results for: %s', 'starter-theme' ), '<span>' . get_search_query() . '</span>' );

      while ( have_posts() ) :
        
				the_post();
				get_template_part( '/lib/template-parts/general/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( '/lib/template-parts/general/content', 'none' );

    endif;
?>

<?php
//get_sidebar();
get_footer();
?>
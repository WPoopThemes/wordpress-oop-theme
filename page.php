<?php 
get_header();
?>

<?php

if (have_posts()) {

  while (have_posts()) {
    the_post();

    get_template_part('/lib/template-parts/content/content', get_post_type());
  }
} else {
  get_template_part('/lib/template-parts/content/content', 'none');
}

?>

<?php 
get_footer();
?>
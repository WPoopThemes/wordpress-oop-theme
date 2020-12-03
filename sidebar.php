<?php
  if ( ! is_active_sidebar( 'main-sidebar' ) ) {
    return;
  }
?>

<aside>
	<?php dynamic_sidebar( 'main-sidebar' ); ?>
</aside>
<?php
$pageID = get_the_ID();
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta itemprop="name" content="<?php echo get_bloginfo('name', 'display'); ?>" />
	<!--Facebook open graph-->
	<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
	<meta property="og:type" content="page" />
	<meta property="og:title" content="<?php echo get_the_title(); ?>" />
	<?php if (has_excerpt($pageID)) : ?>
		<meta property="og:description" content="<?php echo get_the_excerpt($pageID); ?>" />
	<?php endif; ?>
	<meta property="og:image" content="" />
	<!--Twitter card-->
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@flickr" />
	<meta name="twitter:title" content="<?php echo get_the_title(); ?>" />
	<meta name="twitter:description" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:image:alt" content="<?php echo get_the_title(); ?>" />

	<title>
		<?php
		$site_description = get_bloginfo('description', 'display');
		$site_name = get_bloginfo('name');
		//for home page
		if ($site_description && (is_home() || is_front_page())) :
			echo $site_name;
			echo ' | ';
			echo $site_description;
		endif;
		// for other post pages
		if (!(is_home()) && !is_404()) :
			the_title();
			echo ' | ';
			echo $site_name;
		endif;
		?>
	</title>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php get_template_part('/lib/template-parts/shared/navbar'); ?>
	<main id="main-content" class="container-fluid">
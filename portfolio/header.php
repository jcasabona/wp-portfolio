<!DOCTYPE html>
<html lang="en-us">
<head>
<title><?php bloginfo('name'); ?> | <?php wp_title(); ?> </title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php wp_head(); ?>

</head>
	 <body>
	 <div id="wrapper">
		 <header class="group">
			 <div class="contain">
			 	<h1><?php bloginfo('name'); ?></h1>
			 	<h2><?php bloginfo('description'); ?></h2>
			 </div>
		 </header>
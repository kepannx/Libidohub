<?php
/**
 * Template Name:  Blank Page
 *
 **/
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<link href='http://fonts.googleapis.com/css?family=Playfair+Display:700|Open+Sans:600' rel='stylesheet' type='text/css'>
	<link href="<?php echo get_template_directory_uri() ?>/assets/css/blankpage.css" rel="stylesheet" />
</head>
<body <?php body_class(); ?>>
<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$style_css = $style = '';
	if ( has_post_thumbnail() ):
		$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
		$style_css .= ( $image != '' ) ? 'background-image: url(' . $image . ');' : '';
	endif;

	$text_color = get_post_meta( get_the_ID(), 'text_color', true );
	$style_css .= ( $text_color != '' ) ? 'color: ' . $text_color . ';' : '';

	if ( $style_css ) {
		$style = 'style="' . $style_css . '"';
	}

	$custom_title = get_post_meta( get_the_ID(), 'custom_title', true );
	$link_contact = get_post_meta( get_the_ID(), 'link_contact', true );
	?>
	<div class="main" <?php echo ent2ncr( $style ); ?>>
		<div class="container">
			<div class="content">
				<?php
				if ( $custom_title ) {
					echo '<h1 class="info-text">' . $custom_title . ' </h1>';
				} else {
					echo '<h1 class="info-text">' . get_the_title( get_the_ID() ) . ' </h1>';
				}
				?>
				<p><span class="separator-heading"><i class="icon-separator"></i></span></p>
				<?php
				echo '<div class="desc">';
				the_content();
				echo '</div>';
				?>
				<p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default"><?php esc_html_e( 'BACK TO HOME', 'cavada' ); ?></a> &nbsp;
					<?php if ( $link_contact ) {
						echo '<a href="' . $link_contact . '" class="btn btn-default">' . esc_html__( 'CONTACT US', 'cavada' ) . '</a>';
					} ?>
				</p>
			</div>
		</div>
	</div>
<?php endwhile; ?>
</body>
</html>
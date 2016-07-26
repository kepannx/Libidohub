<?php
/**
 * Template Name:  Coming Soon Mode
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
	<link rel='stylesheet' href='<?php echo get_template_directory_uri() ?>/assets/css/font-awesome.min.css?ver=4.2.4' type='text/css' media='all' />
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href="<?php echo get_template_directory_uri() ?>/assets/css/coming-soon.css" rel="stylesheet" />
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

	$coming_soon_date = get_post_meta( get_the_ID(), 'coming_soon_date', true );
	$date             = strtotime( $coming_soon_date );

	$cover_color    = get_post_meta( get_the_ID(), 'cover_color', true );
	$text_copyright = get_post_meta( get_the_ID(), 'text_copyright', true );
	?>
	<div class="main" <?php echo ent2ncr( $style ); ?>>
		<div class="cover <?php echo esc_attr( $cover_color ) ?>" data-color="<?php echo esc_attr( $cover_color ) ?>"></div>
		<div class="container">
			<h1 class="logo">
				<?php
				$coming_soon_logo = get_post_meta( get_the_ID(), 'coming_soon_logo', true );
				if ( $coming_soon_logo ) {
					echo '<img src="' . $coming_soon_logo . '">';
				}
				?>
			</h1>

			<div class="content">
				<?php
				echo '	<div class="subscribe">';
				the_content();
				echo '</div>';
				?>
				<div class="row text-center" id="coming-soon-counter"></div>

				<?php if ( is_active_sidebar( 'comingsoon' ) ) : ?>
					<div class="comingsoon-widget">
						<?php dynamic_sidebar( 'comingsoon' ); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
		<?php if ( $text_copyright ) {
			echo '<div class="footer">
				<div class="container" style="text-align: center; font-size: 12px;">' . $text_copyright . '</div>
			</div>';
		} ?>

	</div>
<?php endwhile; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/jquery.mb-comingsoon.min.js"></script>
<script type="text/javascript">
	<?php echo '
			 $(function () {
 					$("#coming-soon-counter").mbComingsoon({ expiryDate:  new Date(' . date( "Y",  $date ) . ', ' . ( date( "m", $date ) - 1 ) . ', ' . date( "d", $date ) . ', ' . date( "G", $date ) . ',' . date( "i", $date ) . ', ' . date( "s", $date ) . '), speed:100 });
					setTimeout(function () {
						$(window).resize();
					}, 200);
				});
			 '
	 ?>
</script>
</body>
</html>
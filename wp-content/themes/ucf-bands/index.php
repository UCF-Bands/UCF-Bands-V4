<?php
/**
 * Main template file
 *
 * @since   4.0.0
 * @package UCF\Theme
 */

get_header();
?>
	<main class="is-layout-constrained">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;

			the_posts_navigation();
		endif;
		?>
		<p>This is a paragraph.</p>
	</main>
<?php
get_footer();

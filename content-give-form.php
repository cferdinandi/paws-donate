<?php

/**
 * content-page.php
 * Template for page content.
 */

?>

<article>

	<header>
		<h1><?php the_title(); ?></h1>
	</header>

	<?php the_content(); ?>

	<?php
		// Add link to edit pages
		edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
	?>

</article>
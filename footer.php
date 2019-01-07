<?php

/**
 * footer.php
 * Template for footer content.
 */

?>

				<?php if (strtolower(get_bloginfo('description')) === 'donate') : ?>
					<p class="margin-bottom-small">Or donate by check:</p>
					<p>
						PAWS New England<br>
						PO Box 542<br>
						Ashland, MA 01721
					</p>
					<p><em>PAWS New England is a 501(c)(3) non-profit group. All donations are tax deductible.</em></p>
				<?php endif; ?>

			</div><!-- /.container -->
		</main><!-- /#main -->

		<?php wp_footer(); ?>

	</body>
</html>
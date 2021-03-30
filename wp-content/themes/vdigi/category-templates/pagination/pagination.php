<section class="my-4">
	<!-- Phân Trang -->
	    <div class="pagination-archive text-center">
		    <nav aria-label="Page navigation example">
				<?php if(paginate_links()!='') {?>
				<div class="quatrang">
					<?php
					global $wp_query;
					$big = 999999999;
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'prev_text'    => __('«'),
						'next_text'    => __('»'),
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages
						) );
				    ?>
				</div>
				<?php } ?>
		    </nav>
		</div>
	<!-- End Phân Trang -->
</section>
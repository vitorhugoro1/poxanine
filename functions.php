<?php

add_theme_support('post-thumbnails');

function vhr_scripts_load(){
  wp_enqueue_script('jquery');
  wp_enqueue_style('style', get_bloginfo('stylesheet_url'));
  wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css');
  wp_enqueue_style('skeleton', get_template_directory_uri() . '/css/skeleton.css');
  wp_enqueue_style('aniback', get_template_directory_uri() . '/css/aniback.css');
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
}

add_action('wp_enqueue_scripts', 'vhr_scripts_load');

function vhr_paginate(){
  ?>
  <div class="pagination">
    <?php
				global $wp_query;
				$current = max( 1, absint( get_query_var( 'paged' ) ) );
				$pagination = paginate_links( array(
					'base' => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
					'format' => '?paged=%#%',
					'current' => $current,
					'total' => $wp_query->max_num_pages,
					'type' => 'array',
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				) ); ?>
      <?php if ( ! empty( $pagination ) ) : ?>
        <ul class="pagination-list">
          <?php foreach ( $pagination as $key => $page_link ) : ?>
          <?php
            if ( strpos( $page_link, 'current' ) !== false ) :
           ?>
            <li class="pagination-item">
              <a href="<?php echo $_SERVER[REQUEST_URI]; ?>" class="pagination-link active"><?php echo $current; ?></a>
            </li>
          <?php else:
            $dom = new DomDocument();
            $dom->loadHTML($page_link);
            $urls = $dom->getElementsByTagName('a');
            $links = array();

            foreach($urls as $link) {
              $links[] = array('url' => $link->getAttribute('href'), 'text' => $link->nodeValue);
            }
            ?>
            <li class="pagination-item">
              <a href="<?php echo $links[0]['url']; ?>" class="pagination-link<?php if ( strpos( $page_link, 'current' ) !== false ) { echo ' active'; } ?>"><?php echo ($links[0]['text'] != '') ? $links[0]['text'] : '...'; ?></a>
            </li>
          <?php endif; ?>
          <?php endforeach ?>
        </ul>
      <?php endif ?>
    <?php
    ?>
  </div>
  <?php
}

<?php

require_once get_template_directory() . '/cmb2/init.php';
include get_template_directory() . '/blogroll-widget/blogroll-widget.php';
include get_template_directory() . '/vhr-search-widget/vhr-search-widget.php';

add_theme_support('post-thumbnails');

function vhr_scripts_load(){
  wp_enqueue_script('jquery');
  wp_enqueue_style('style', get_bloginfo('stylesheet_url'));
  wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css');
  wp_enqueue_style('skeleton', get_template_directory_uri() . '/css/skeleton.css');
  // wp_enqueue_style('aniback', get_template_directory_uri() . '/css/aniback.css');
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

/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'textdomain' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="sidebar %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );

function vhr_blogroll_url(){
  $prefix = '_vhr_';

  $url = new_cmb2_box(array(
        'id' => 'url_metabox',
        'title' => 'Caminho do blog',
        'object_types' => array('blogroll'),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
      ));

  $url->add_field(array(
    'id' => $prefix.'url',
    'name' => 'Caminho do blog',
    'type' => 'text_url',
    'description' => 'Exemplo http://poxanine.com.br',
    'attributes'  => array(
      'required'  => true,
      'placeholder' => 'Url do blog'
    )
  ));
}

add_action('cmb2_admin_init', 'vhr_blogroll_url');
  /**
  * Registers a new post type
  * @uses $wp_post_types Inserts new post type object into the list
  *
  * @param string  Post type key, must not exceed 20 characters
  * @param array|string  See optional args description above.
  * @return object|WP_Error the registered post type object, or an error object
  */
  function vhr_register_blogroll() {

    $labels = array(
      'name'                => __( 'Blogroll', 'text-domain' ),
      'singular_name'       => __( 'Blogroll', 'text-domain' ),
      'add_new'             => _x( 'Adicionar novo blog', 'text-domain', 'text-domain' ),
      'add_new_item'        => __( 'Adicionar novo blog', 'text-domain' ),
      'edit_item'           => __( 'Editar blog', 'text-domain' ),
      'new_item'            => __( 'Novo blog', 'text-domain' ),
      'view_item'           => __( 'Ver blog', 'text-domain' ),
      'search_items'        => __( 'Procurar blogs', 'text-domain' ),
      'not_found'           => __( 'Nenhum blog encontrado', 'text-domain' ),
      'not_found_in_trash'  => __( 'Nenhum blog encontrado no lixo', 'text-domain' ),
      'parent_item_colon'   => __( 'Blog pai:', 'text-domain' ),
      'menu_name'           => __( 'Blogroll', 'text-domain' ),
    );

    $args = array(
      'labels'                   => $labels,
      'hierarchical'        => false,
      'taxonomies'          => array(),
      'public'              => false,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => null,
      'menu_icon'           => null,
      'show_in_nav_menus'   => true,
      'publicly_queryable'  => false,
      'exclude_from_search' => false,
      'has_archive'         => false,
      'query_var'           => false,
      'can_export'          => true,
      'rewrite'             => true,
      'capability_type'     => 'post',
      'supports'            => array('title', 'thumbnail' )
    );

    register_post_type( 'blogroll', $args );
  }

  add_action( 'init', 'vhr_register_blogroll' );

function poxanine_comment_list($comment, $args, $depth){
  ?>
    <li class="comment-item" id="div-comment-<?php comment_ID(); ?>">
      <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
          <br />
    <?php endif; ?>
      <div class="author">
        <?php printf( __( '<cite class="fn">%s</cite> <a href="%s" class="comment-site">%s</a>' ), get_comment_author_link(), get_comment_author_url(), __('Blog/Site') ); ?>
      </div>
      <div class="comment-text">
        <?php comment_text(); ?>
      </div>
      <div class="comment-interact">
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
      </div>
    </li>
  <?php
}

add_action('pre_get_posts', 'myprefix_query_offset', 1 );
function myprefix_query_offset(&$query) {

    if ( ! $query->is_archive() ) {
        return;
    }

    $fp = 5;
    $ppp = 7;

    if ( $query->is_paged ) {
        $offset = $fp + ( ($query->query_vars['paged'] - 2) * $ppp );
        $query->set('offset', $offset );
        $query->set('posts_per_page', $ppp );

    } else {
        $query->set('posts_per_page', $fp );
    }

}

add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );
function myprefix_adjust_offset_pagination($found_posts, $query) {

    $fp = 5;
    $ppp = 7;

    if ( $query->is_archive() ) {
        if ( $query->is_paged ) {
            return ( $found_posts + ( $ppp - $fp ) );
        }
    }
    return $found_posts;
}

function new_excerpt_more($more) {
       global $post;
	return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

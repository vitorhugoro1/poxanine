<?php

if(file_exists(get_template_directory() . '/cmb2/init.php')){
  require_once get_template_directory() . '/cmb2/init.php';
}

include get_template_directory() . '/blogroll-widget/blogroll-widget.php';

add_theme_support('post-thumbnails');
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
add_theme_support( 'automatic-feed-links' );

function vhr_scripts_load(){
  wp_enqueue_script('jquery');
  wp_enqueue_style('style', get_bloginfo('stylesheet_url'));
  wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css');
  wp_enqueue_style('skeleton', get_template_directory_uri() . '/css/skeleton.css');
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
}

add_action('wp_enqueue_scripts', 'vhr_scripts_load');

function vhr_paginate(){
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
  ) );

 if ( ! empty( $pagination ) ) : ?>
  <div class="pagination">
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
              <a href="<?php echo ($links[0]['text'] != '') ? $links[0]['url'] : 'javascript:void(0);'; ?>" class="pagination-link<?php if ( strpos( $page_link, 'current' ) !== false ) { echo ' active'; } ?>"><?php echo ($links[0]['text'] != '') ? $links[0]['text'] : '...'; ?></a>
            </li>
          <?php endif; ?>
          <?php endforeach ?>
        </ul>
  </div>
<?php endif;
}

/**
 * Add a sidebar.
 */
function vhr_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'textdomain' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'vhr_theme_slug_widgets_init' );

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

function vhr_comment_list($comment, $args, $depth){
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

add_action('pre_get_posts', 'vhr_query_offset', 1 );
function vhr_query_offset(&$query) {

    if ( ! $query->is_archive() && ! $query->is_home() ) {
        return;
    }

    $fp = 5;
    $ppp = 8;

    if ( $query->is_paged ) {
        $offset = $fp + ( ($query->query_vars['paged'] - 2) * $ppp );
        $query->set('offset', $offset );
        $query->set('posts_per_page', $ppp );

    } else {
        $query->set('posts_per_page', $fp );
    }
}

add_filter('found_posts', 'vhr_adjust_offset_pagination', 1, 2 );
function vhr_adjust_offset_pagination($found_posts, $query) {

    $fp = 5;
    $ppp = 8;

    if ( $query->is_home() || $query->is_archive()  ) {
        if ( $query->is_paged ) {
            return ( $found_posts + ( $ppp - $fp ) );
        }
    }
    return $found_posts;
}

function vhr_excerpt_more($more) {
       global $post;
	return ' ...';
}
add_filter('excerpt_more', 'vhr_excerpt_more');

function vhr_related_posts(){
  global $post;

  $tags = wp_get_post_tags($post->ID);

  if($tags){
    ?>
      <div class="post-box">
        <h4 class="post-box-title">Você também pode gostar</h4>
      </div>
    <?php
    $tags_ids = array();
    foreach($tags as $individual_tags){
      $tags_ids[] = $individual_tags->term_id;
    }

    $args = array(
      'tag__in' => $tags_ids,
      'post__not_in'  => array($post->ID),
      'posts_per_page'  => 3,
      'ignore_sticky_posts' => 1
    );

    $my_related = new WP_Query($args);

    while($my_related->have_posts()){
      $my_related->the_post();
       ?>
        <div class="item-related">
          <?php if(has_post_thumbnail()): ?>
            <a href="<?php the_permalink() ?>">
              <?php the_post_thumbnail( 'full' ) ?>
            </a>
          <?php endif; ?>
          <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
          <span class="date"><?php the_date() ?></span>
        </div>
      <?php
    }
  }
}

function vhr_post_author(){
  global $post;

  ?>
    <div class="author-img">
      <?php echo get_avatar($post->post_author) ?>
    </div>
    <div class="author-content">
      <h5><?php echo get_the_author_meta('display_name', $post->post_author) ?></h5>
      <p><?php echo get_the_author_meta('user_description', $post->post_author) ?></p>
    </div>
  <?php
}

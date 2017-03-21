<?php get_header(); ?>
<div id="main">
  <div class="container">
    <div class="row">
      <div class="nine columns">
      <?php if (have_posts()) : ?>
        <?php $first = true; ?>
      	<?php while (have_posts()) : the_post(); ?>
          <article id="post-<?php the_ID() ?>" <?php post_class( '' ) ?>>
            <div class="post-header">
              <span class="cat"><?php the_category(' ') ?></span>
              <h2><?php the_title() ?></h2>
              <span class="date"><?php the_date() ?></span>
            </div>
            <div class="post-img">
              <?php if(has_post_thumbnail()) : ?>
                <a href="<?php the_permalink() ?>">
                  <?php the_post_thumbnail( 'full' ) ?>
                </a>
              <?php endif; ?>
            </div>
            <div class="post-entry">
              <?php the_content() ?>
            </div>
            <div class="post-meta">
              <div class="meta-comments"><a href="<?php comments_link() ?>"><?php comments_number('0 Comentários', '1 Comentário', '% Comentários' );?></a></div>
              <div class="meta-share">
                <?php vhr_share_links() ?>
              </div>
            </div>
            <div class="post-tags">
              <?php the_tags( 'Tags: ', $sep = ', ', $after = '' ) ?>
            </div>
            <div class="post-author">
              <?php vhr_post_author() ?>
            </div>
            <div class="post-related">
              <?php vhr_related_posts() ?>
            </div>
            <div class="post-comments" id="comments">
              <?php comments_template(); ?>
            </div>
          </article>
      	<?php endwhile; ?>

      	<?php else : ?>

      		<?php // No Posts Found ?>

      <?php endif; ?>
      </div>
      <!-- Fim posts loop -->
    <?php get_sidebar() ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>

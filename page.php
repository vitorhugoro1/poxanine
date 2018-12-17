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
                  <h1><?php the_title() ?></h1>
                  <h4> Em <span class="cat"><?php the_category(' ')?></span> · <span class="date"><?php the_date('d M Y') ?></span></h4>
              </div>
            <?php if(has_post_thumbnail()) : ?>
              <div class="post-img">
                  <a href="<?php the_permalink() ?>">
                    <?php the_post_thumbnail( 'full' ) ?>
                  </a>
              </div>
            <?php endif; ?>
            <div class="post-entry">
              <?php the_content() ?>
            </div>
            <div class="post-meta">
              <div class="meta-comments">
                <?php if (comments_open()) : ?>
                  <a href="<?php comments_link() ?>"><?php comments_number('0 Comentários', '1 Comentário', '% Comentários'); ?></a>
                <?php endif; ?>
              </div>
              <div class="meta-share">
                <?php vhr_share_links() ?>
              </div>
            </div>
            <?php vhr_post_tags() ?>
            <?php vhr_post_author() ?>
            <?php vhr_related_posts() ?>
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

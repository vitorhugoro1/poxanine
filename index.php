<?php get_header(); ?>
<div id="main">
  <div class="container">
    <div class="row">
      <div class="nine columns">
        <?php if (have_posts()) : ?>
          <ul class="ul-grid">
            <?php $c = 0; ?>
          <?php while (have_posts()) : the_post(); ?>
              <?php if(!is_paged() && 0 == $c): ?>
              <article id="post-<?php the_ID() ?>" <?php post_class( 'hero-article' ) ?>>
                <div class="post-header">
                  <span class="cat"><?php the_category(' ') ?></span>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                  <span class="date"><?php the_date() ?></span>
                </div>
                <?php if(has_post_thumbnail()) : ?>
                  <div class="post-img">
                      <a href="<?php the_permalink() ?>">
                        <?php the_post_thumbnail( 'full' ) ?>
                      </a>
                  </div>
                <?php endif; ?>
                <div class="post-entry">
                  <?php the_content('<span class="more-button">Continue lendo</span>', true) ?>
                </div>
                <div class="post-meta">
                  <div class="meta-comments"><a href="<?php comments_link() ?>"><?php comments_number('0 Comentários', '1 Comentário', '% Comentários' );?></a></div>
                  <div class="meta-share">
                    <span class="share-text">Compartilhe:</span>
                    <a href="#" class="facebook"></a>
                    <a href="#" class="pinterest"></a>
                    <a href="#" class="twitter"></a>
                  </div>
                </div>
              </article>
            <?php $c+=1; ?>
            <?php else: ?>
              <li>
                <article id="post-<?php the_ID() ?>" <?php post_class( 'grid-item' ) ?>>
                  <?php if(has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink() ?>">
                          <?php the_post_thumbnail( 'full' ) ?>
                        </a>
                    </div>
                  <?php endif; ?>
                  <div class="post-header">
                    <span class="cat"><?php the_category(' ') ?></span>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                  </div>
                  <div class="post-entry">
                    <?php the_excerpt('...') ?>
                  </div>
                  <div class="list-meta">
                    <span class="date"><?php the_date() ?></span>
                  </div>
                </article>
              </li>
            <?php endif; ?>

          <?php endwhile; ?>
        </ul>
            <?php vhr_paginate() ?>
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

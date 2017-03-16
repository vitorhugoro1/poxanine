<?php get_header(); ?>
<div class="row">
  <div class="nine columns">
  <?php if (have_posts()) : ?>
    <?php $first = true; ?>
  	<?php while (have_posts()) : the_post(); ?>

      <div class="post">
        <header>
          <span class="cat"><?php the_category(' ') ?></span>
          <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
          <span class="date"><?php the_date() ?></span>
          <?php if(has_post_thumbnail() && !$first) : ?>
            <a href="#"><img src="img/thumbnail.jpg" class="thumbnail"></a>
          <?php endif; ?>
        </header>
        <article>
          <?php if($first): ?>
            <?php the_content() ?>
          <?php else: ?>
            <?php the_excerpt() ?>
          <?php endif; ?>
        </article>
        <footer>
          <div class="post-tags">
            <?php the_tags('') ?>
          </div>
        <?php if(!$first) : ?>
          <a href="<?php the_permalink() ?>" class="ver-mais">Ver mais +</a>
        <?php endif ?>
        </footer>
      </div>
      <?php $first = false; ?>

  	<?php endwhile; ?>
      <?php vhr_paginate() ?>
  	<?php else : ?>

  		<?php // No Posts Found ?>

  <?php endif; ?>
  </div>
  <!-- Fim posts loop -->
<?php get_sidebar() ?>
</div>
<?php get_footer(); ?>

<?php get_header(); ?>
<div class="row">
  <div class="nine columns">
  <?php if (have_posts()) : ?>
    <?php $first = true; ?>
  	<?php while (have_posts()) : the_post(); ?>

      <div class="post">
        <header>
          <h2><?php the_title() ?></h2>
          <div class="info">
            <?php the_category(', ') ?> - <?php the_date( 'd &#149; m &#149; Y' ) ?>
          </div>
        </header>
        <article>
          <?php the_content() ?>
        </article>
        <footer>
          <div class="share">
            <a href="#" class="facebook">Share</a>
            <a href="#" class="pinterest">Pin</a>
            <a href="#" class="twitter">Tweet</a>
          </div>
          <div class="post-tags">
            <?php the_tags('') ?>
          </div>
          <?php comments_template(); ?>
          <!-- <div class="comments">
            <h3><span>Comentários</span></h3>
            <form>
              <div class="row">
                <div class="six columns">
                  <label for="name">Nome*</label>
                  <input class="u-full-width" type="text" id="name" name="author" placeholder="Nome">
                </div>
                <div class="six columns">
                  <label for="email">Email*</label>
                  <input class="u-full-width" type="email" id="email" name="email" placeholder="Email">
                </div>
              </div>
              <label for="site">Site/Blog</label>
              <input class="u-full-width" type="url" id="site" name="url" placeholder="Site">
              <textarea class="u-full-width" name="comment" placeholder="Mensagem"></textarea>
              <input type="submit" class="button-primary" value="Comentar">
            </form>
            <ul class="comments-list">
              <li class="comment-item">
                <div class="author">
                  Vitor <a href="#">email@email.com</a> - <a href="#">Site</a>
                </div>
                <div class="comment-text">
                  Comentário sagaz nas BILADAS
                </div>
                <div class="comment-interact">
                  <a href="#">Responder</a>
                </div>
              </li>
            </ul>
          </div> -->
        </footer>
      </div>

  	<?php endwhile; ?>

  	<?php else : ?>

  		<?php // No Posts Found ?>

  <?php endif; ?>
  </div>
  <!-- Fim posts loop -->
<?php get_sidebar() ?>
</div>
<?php get_footer(); ?>

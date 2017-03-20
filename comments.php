<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">Este artigo está protegido por password. Insira-a para ver os comentários.</p>
	<?php
		return;
	}
?>

	<h3><span> <?php comments_number('0 Comentários', '1 Comentário', '% Comentários' );?> </span></h3>

	<?php if ( have_comments() ) : ?>

		<ol class="comments-list">
		<?php wp_list_comments(array(
      'avatar_size' => 32,
      'reply_text'  => 'Responder',
      'per_page'    => 4,
      'callback'    => 'vhr_comment_list'
    )); ?>
    </ol>

		<?php if ($wp_query->max_num_pages > 1) : ?>
		<div class="pagination">
    	<ul>
    		<li class="older"><?php previous_comments_link('Anteriores'); ?></li>
   			<li class="newer"><?php next_comments_link('Novos'); ?></li>
   		</ul>
    </div>
    <?php endif; ?>

	<?php endif; ?>

	<?php if ( comments_open() ) : ?>

	<div id="respond">
			<h3><span>Comente aqui!</span></h3>

			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				<?php if ( $user_ID ) : ?>

				<!-- <p>Autentificado como <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="Sair desta conta">Sair desta conta &raquo;</a></p> -->

				<?php else : ?>
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
                <?php endif; ?>

                <textarea class="u-full-width" name="comment" placeholder="Mensagem"></textarea>
                <input type="submit" class="button-primary" value="Comentar">

                <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post->ID); ?>
        </form>
        <p class="cancel"><?php cancel_comment_reply_link('Cancelar Resposta'); ?></p>
		</div>
	 <?php else : ?>
<?php endif; ?>

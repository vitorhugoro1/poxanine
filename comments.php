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

<?php if (comments_open()) : ?>
	<div class="post-box">
		<h3 class="post-box-title"><?php comments_number('Sem Comentários', '1 Comentário', '% Comentários' );?></h3>
	</div>
<?php endif; ?>

<?php if ( have_comments() && comments_open() ) : ?>
<ol class="comments-list">
  <?php wp_list_comments([
    'avatar_size' => 32,
    'reply_text'  => 'Responder',
    'type'				=> 'comment',
    'per_page'    => -1,
    'callback'    => 'vhr_comment_list'
  ]); ?>
</ol>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<div id="respond" class="comment-respond">
		<h3 class="comment-reply-title">Deixe um comentário <small><?php cancel_comment_reply_link( 'Cancelar' ) ?></small></h3>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form">
			<?php if ( $user_ID ) : ?>
			<?php else : ?>
              <div class="row">
                <div class="six columns">
                  <label for="name">Nome <span class="required">*</span></label>
                  <input class="u-full-width" type="text" id="name" name="author" placeholder="Nome">
                </div>
                <div class="six columns">
                  <label for="email">Email <span class="required">*</span></label>
                  <input class="u-full-width" type="email" id="email" name="email" placeholder="Email">
                </div>
              </div>
              <label for="site">Site/Blog</label>
              <input class="u-full-width" type="url" id="site" name="url" placeholder="Site">
              <?php endif; ?>

              <textarea class="u-full-width" name="comment" placeholder="Mensagem"></textarea>
              <input type="submit" value="Comentar">

              <?php comment_id_fields(); ?>
              <?php do_action('comment_form', $post->ID); ?>
      </form>
		</div>
	 <?php else : ?>
<?php endif; ?>

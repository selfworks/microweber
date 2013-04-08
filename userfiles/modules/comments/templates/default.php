<?php

/*

type: layout

name: Default

description: Default comments template

*/

  //$template_file = false; ?>
<div class="comments-template-stylish">
  <?php
       $cur_user = user_id();
             if($cur_user != false){
              $cur_user_data = get_user($cur_user);
             }
        ?>
  <? if (isarr($comments)): ?>
  <? if($form_title != false): ?>
  <h2><? print $form_title ?></h2>
  <? elseif($display_comments_from  != false and $display_comments_from   == 'recent'): ?>
  <h2>Recent comments</h2>
  <? else : ?>
  <h2>Comments for <strong>
    <?php  $post = get_content_by_id($data['rel_id']); print $post['title']; ?>
    </strong></h2>
  <? endif; ?>
  <div class="comments" id="comments-list-<? print $data['id'] ?>">
    <? foreach ($comments as $comment) : ?>
    <?php
    $required_moderation = get_option('require_moderation', 'comments')=='y';

    if(!$required_moderation or $comment['is_moderated'] == 'y' or (!empty($_SESSION) and  $comment['session_id'] == session_id())){
  ?>
    <div class="clearfix comment" id="comment-<? print $comment['id'] ?>">
      <div class="row">
        <?php

  $avatars_enabled = get_option('avatar_enabled', 'comments')=='y';

  $comment_author =  get_user($comment['created_by']) ;
  if(!empty($comment_author)){
	  // $comment['comment_name'] = user_name($comment_author['id']);
  }

  
  
  
  

  ?>
        <?php if($avatars_enabled){ ?>
        <div class="span1">
          <?php $avatar_style =  get_option('avatar_style', 'comments'); ?>
          <?php  if (isset($comment_author['thumbnail'])  and isset($comment_author['thumbnail']) != ''){ ?>
          <img src="<?php print ($comment_author['thumbnail']);  ?>" width="60" height="60" class="img-polaroid comment-image" alt="<? print addslashes($comment['comment_name']) ?>" />
          <?  }  else  {   ?>
          <?php   if($avatar_style == '4'){ ?>
          <img src="<?php print thumbnail(get_option('avatartype_custom', 'comments'), 60, 60);  ?>" class="img-polaroid comment-image"  width="60" height="60"  alt="<? print addslashes($comment['comment_name']) ?>" />
          <?php } else if($avatar_style == '1' || $avatar_style == '3'){ ?>
          <img src="<?php print thumbnail($config['url_to_module']. '/img/comment-default-'.$avatar_style.'.jpg', 60, 60);  ?>"  width="60" height="60"  class="img-polaroid comment-image" alt="<? print addslashes($comment['comment_name']) ?>" />
          <?php } else if($avatar_style == '2'){ ?>
          <span class="img-polaroid  random-color"> <span style="background-color: <?php print random_color(); ?>"> </span> </span>
          <? } else if(isset( $comment_author['thumbnail'])){ ?>
          <img src="<?php print ($comment_author['thumbnail']);  ?>" width="60" height="60" class="img-polaroid comment-image" alt="<? print addslashes($comment['comment_name']) ?>" />
          <?php } else {  ?>
          <img src="<?php print thumbnail($config['url_to_module']. '/img/comment-default-1.jpg', 60, 60);   ?>"  width="60" height="60"  class="img-polaroid comment-image" alt="<? print addslashes($comment['comment_name']) ?>" />
           <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="span5">
          <div class="comment-content">
            <div class="comment-author"> <? print $comment['comment_name'] ?> </div>
            <div class="comment-body">
              <? if($required_moderation != false and  $comment['is_moderated'] == 'n' ): ?>
              <em class="comment-require-moderation">Your comment requires moderation</em><br />
              <? endif; ?>
              <? print nl2br($comment['comment_body'] ,1);?> </div>
          </div>
        </div>
      </div>
    </div>
    <? } endforeach; ?>
    <? if($paging != false and intval($paging) > 1 and isset($paging_param)): ?>
    <? print paging("num={$paging}&paging_param={$paging_param}") ?>
    <? endif; ?>
  </div>
  <? else: ?>
  <h2>No comments</h2>
  <?php endif; ?>
  <hr>
  <?php if(!$login_required or $cur_user != false): ?>
  <div class="mw-comments-form" id="comments-<? print $data['id'] ?>">
    <form autocomplete="on" id="comments-form-<? print $data['id'] ?>">
      <input type="hidden" name="rel_id" value="<? print $data['rel_id'] ?>">
      <input type="hidden" name="rel" value="<? print $data['rel'] ?>">
      <? if($form_title != false): ?>
      <input type="hidden" name="comment_subject" value="<? print $form_title ?>">
      <?php endif; ?>
      <h2>Leave a comment</h2>
      <?php if( $cur_user == false) :  ?>
      <div class="row-fluid">
        <div class="span4 comment-field">
          <input class="input-medium" placeholder="Your name" required type="text" name="comment_name">
        </div>
        <div class="span4 comment-field">
          <input class="input-medium" placeholder="Website" type="text" name="comment_website">
        </div>
        <div class="span4 comment-field">
          <input class="input-medium" placeholder="Your email" required type="email"  name="comment_email">
        </div>
      </div>
      <?php else: ?>
      <span class="comments-user-profile">You are commenting as:



      <?php if(isset($cur_user_data['thumbnail']) and trim($cur_user_data['thumbnail'])!=''): ?>
      <span class="mw-user-thumb mw-user-thumb-small"> <img style="vertical-align:middle" src="<? print $cur_user_data['thumbnail'] ?>"  height="24" width="24" /> </span>
      <?php endif; ?>
      <span class="comments-user-profile-username"> <? print user_name($cur_user_data['id']); ?> </span> <small><a href="<? print api_url('logout') ?>">(Logout)</a></small> </span>
      <?php endif; ?>
      <div class="row-fluid">
        <div class="span12 comment-field">
          <textarea required placeholder="Comment" name="comment_body"></textarea>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <div class="input-prepend captcha pull-left"> <span class="add-on"> <img title="Click to refresh image" alt="Captcha image" class="mw-captcha-img" src="<? print site_url('api_html/captcha') ?>" onclick="mw.tools.refresh_image(this);"> </span>
            <input type="text" name="captcha" required class="input-medium" placeholder="Enter text">
          </div>
          <input type="submit" class="btn pull-right" value="Add comment">
        </div>
      </div>
    </form>
  </div>
  <?php else :  ?>
  <div class="alert"> You have to <a href='<?php print site_url(); ?>login' class="comments-login-link">log in</a> or <a class="comments-register-link" href='<?php print site_url(); ?>register'>register</a> to post a comment. </div>
  <?php endif; ?>
</div>

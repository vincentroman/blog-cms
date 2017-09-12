<h2>
<a href="post.php?p_id=<?= $post_id; ?>"><?= $post->post_title; ?></a>
</h2>
<p class="lead">
    by <a href="index.php"><?= $post->post_author; ?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> Posted on <?= $post->post_date; ?></p>
<hr>
<p><strong>Tags: </strong><?= $post->post_tags; ?></p>
<hr>
<a href="post.php?p_id=<?= $post_id; ?>"><img class="img-responsive" src='admin/img/<?= $post->post_img; ?>' alt="<?= $post->post_img_alt; ?>"></a>
<hr>
<p><?= $post_content; ?></p>
<a class="btn btn-primary" href="post.php?p_id=<?= $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<hr style='border: 1px solid grey;'>
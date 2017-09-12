<div class='media'>
    <a class='pull-left' href="#">
        <img class='media-object' src="http://placehold.it/64x64" alt="">
    </a>
    <div class='media-body'>
        <h4 class='media-heading'><?= $com->comment_author; ?>
            <small><?= $com->comment_date; ?></small>
        </h4>
        <?= $com->comment_content; ?>
    </div>
</div>
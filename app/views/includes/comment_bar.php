<hr>
<h4>Comments</h4>
<form action="<?php echo URL_ROOT; ?>/comments/add?post_id=<?php echo $data["post"]->id; ?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-10">
            <input type="text" name="comment_body" class="form-control">
        </div>
        <div class="form-group col-md-2">
            <input type="submit" value="Submit" class="btn btn-dark form-control">
        </div>
    </div>
</form>
<?php foreach($data["comments"] as $comment): ?>
    <div class="card card-body mb-3">
        <div class="bg-light p-2 mb-3">
            Written by <?php echo $comment->name; ?> on <?php echo $comment->created_at; ?>
        </div>
        <p class="card-text"><?php echo $comment->body ?></p>
    </div>
<?php endforeach; ?>
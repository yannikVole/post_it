<?php require APP_ROOT . "/views/includes/header.php";?>
<a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fas fa-undo-alt"></i>Back</a>
<br>
<h1><?php echo $data["post"]->title;?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?php echo $data["user"]->name; ?> on <?php echo $data["post"]->created_at; ?>
</div>
<p><?php echo $data["post"]->body; ?></p>
<img src="<?php echo URL_ROOT."/".$data["post"]->img_url;?>" class="img-fluid" alt="">
<?php if($data["post"]->user_id == $_SESSION["user_id"]): ?>
<hr>
<a href="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data["post"]->id; ?>" class="btn btn-dark">Edit</a>
<form action="<?php echo URL_ROOT; ?>/posts/delete/<?php echo $data["post"]->id; ?>" method="post" class="float-right">
    <input type="submit" value="Delete" class="btn btn-danger">
</form>
<?php endif; ?>
<?php require APP_ROOT . "/views/includes/comment_bar.php";?>
<?php require APP_ROOT . "/views/includes/footer.php";?>
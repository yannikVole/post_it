<?php require APP_ROOT . "/views/includes/header.php";?>

    <a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fas fa-undo-alt"></i>Back</a>
    <div class="card card-body bg-light mt-5">
        <h2>Edit Post</h2>
        <form action="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data["post_id"] ?>" method="POST">
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data["title_error"])) ? 'is-invalid' : '' ?>" value="<?php echo $data["title"] ?>">
            <span class="invalid-feedback"><?php echo $data["title_error"]; ?></span>
        </div>
        <div class="form-group">
            <label for="body">Body: </label>
            <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data["body_error"])) ? 'is-invalid' : '' ?>"><?php echo $data["body"] ?></textarea>
            <span class="invalid-feedback"><?php echo $data["body_error"]; ?></span>
        </div>
        <input type="submit" class="btn btn-success" value="Submit">
        </form>
    </div>

<?php require APP_ROOT . "/views/includes/footer.php";?>
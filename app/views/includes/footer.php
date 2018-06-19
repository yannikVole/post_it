</div>
    <div class="col-md-2">
    <?php require APP_ROOT."/views/includes/popup_chatbox.php"?>
    <?php require APP_ROOT."/views/includes/sidebar.php" ?>
    </div>
</div>
</div>
<?php $loggedinUserId = (isset($_SESSION["user_id"]))?$_SESSION["user_id"]:''; ?>
<script type="text/javascript">
var loggedInUser = <?php echo $loggedinUserId; ?>
</script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="<?php echo URL_ROOT;?>/js/module_params.js"></script>
<script src="<?php echo URL_ROOT;?>/js/modules/sidebar_module.js"></script>
<script src="<?php echo URL_ROOT;?>/js/modules/chat_module.js"></script>
<script src="<?php echo URL_ROOT;?>/js/main.js"></script>
</body>
</html>
<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
?>

    <div class="container">
      <form action="" method="post" enctype="multipart/form-data">

        <p><input required type="text" placeholder="title" pattern="[a-zA-Z0-9_-. ]{5,50}" name="title"></p>

        <p><textarea placeholder="description of the gallery" name="description"></textarea></p>

        <input required name="pics[]" id="filesToUpload" type="file" multiple="" />
        <br>
        <button class="btn btn-primary" name="create" type="submit">submit gallery</button>
      </form>
    </div> <!-- /container -->


<?php } ?>
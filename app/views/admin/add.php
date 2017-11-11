<?php
function content($data){
extract($data);
?>
<div class="container">
  <form action='' method='post'>
    <p>
      <label for='title'>Title</label>
      <input type='text' name='title' id='title' value='<?php echo $_POST['title'];?>' required autofocus/>
    </p>
    <p>
      <textarea name='body' rows='20' cols='60' required><?php echo $_POST['body'];?></textarea>
    </p>
    <p>
      <label for='tags'>Tags</label>
      <input type='text' name='tags' value='<?php echo $_POST['tags'];?>' r_equired/> your tags, example :camera, sony, nex
    </p>
    <p>
      <input type='checkbox' name='public'/> Post Public // else it's kept in draft
    </p>
    <p>
      <input type='submit' name='post' value='Add Post'/>
    </p>
  </form>
</div>

<?php
}
?>
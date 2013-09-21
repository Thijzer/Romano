<?php
function js_after(){?>

<script type="text/javascript">
$(document).ready(function(){
        $(".collapse").collapse()
});
</script>

<?}
function content($data){
extract($data);
$c = count($comments);
?>

  <div class="container">
    <div class="row">
      <div class="col-sm-8">

        <div class="well">
          <header class="page-header">
            <h1><?echo $post['title']?></h1>
            <p>by <?echo $post['user']?> published on <?echo $post['date']?></p>
          </header>
          <p><?echo $post['body']?></p>
        </div>
        <hr>
          <label class="btn btn-danger" data-toggle="collapse" data-target="#demo"><?echo $c;if($c == 1){echo ' comment';}else{echo ' comments';}?></label>
          <div id="demo" class="collapse in">
            <form action='' method='post'>
              <label for='user'>your comment</label>
              <p>
                <textarea name='body' rows='5' cols='50' maxlength="128" required></textarea>
              </p>
              <label for='user'>username</label>
              <p>
                <input type='text' name='user' id='user' required/>
                <input type='submit' name='post' value='add Comment'/>
              </p>
            </form>

            <div>
              <?if (!empty($comments)){for ($i = 0; $i < $c; $i++){?>
              <div id="<?echo $comments[$i]['id']?>"><h5><?echo $comments[$i]['user']?></h5>
                <p><?echo $comments[$i]['body']?></p>
                  <p>posted on : <?echo $comments[$i]['date']?></p>
              </div>
              <hr class="dotted">
              <?}}?>
            </div>

          </div>

      </div>

    </div>
  </div>

<?}?>
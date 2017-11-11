<?php
function content($data){
extract($data);
?>

<div class="container">
  <div class="row">

    <div class="col-md-8 col-xl-8" role="main">

      <?$c = count($post); for ($i = 0; $i < $c; $i++){?>
      <div class="well">
        <h3>
          <a href="/blog/article/<?echo $post[$i]['pid']?>/"><?echo $post[$i]['title']?></a>
        </h3>
        <span>posted on <?echo $post[$i]['date']?></span>
        <span>by <a href="/blog/<?echo $post[$i]['user']?>/"><?echo $post[$i]['user']?></a></span>
        <span> with <?echo $post[$i]['total_comments'];if(empty($post[$i]['total_comments'])){echo 'no';}if($post[$i]['total_comments'] == 1){echo ' comment';}else{echo ' comments';}?></span>
        <HR>
        <p><?echo $post[$i]['preview']?><a href="/blog/article/<?echo $post[$i]['pid']?>/"> more..</a></p>
      </div>
      <?}?>
    </div>

    <div class="col-md-4 col-xl-4 hidden-xs">
      <div class="sidebar" role="complementary">
        <div>
          <h3>Recent Posts</h3>
          <ul>
            <?$c = count($titles); for ($i = 0; $i < $c; $i++){?>
            <li><a href="/blog/article/<?echo $titles[$i]['pid']?>"><?echo $titles[$i]['title']?></a></li>
            <?}?>
          </ul>
        </div>
        <div>
          <h3 class="widget-title">Categories</h3>
          <ul>
            <li>Awaiting update</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>

<?}?>
<?php
function content($data) {
extract($data);
?>

    <div class="container">
      <div class="row">
        <div class="col-md-8 col-xl-8" role="main">
<?php
$c = count($post);
for ($i = 0; $i < $c; $i++)
  {
    $page = strtolower(str_replace(' ', '-', $post[$i]['title']));
    ?>
          <div class="well">
            <h3>
              <a href="/blog/article/<?php echo $post[$i]['pid'];?>/<?php echo $page;?>.html"><?php echo $post[$i]['title'];?></a>
            </h3>
            <span>posted on <?php echo $post[$i]['date'];?></span>
            <span>by <a href="/blog/<?php echo $post[$i]['user'];?>/"><?php echo $post[$i]['user'];?></a></span>
            <span> with <?php echo $post[$i]['total_comments'];
            if(empty($post[$i]['total_comments'])){ echo 'no';}
            if($post[$i]['total_comments'] == 1){ echo ' comment';}
            else{ echo ' comments';}?>
            </span>
            <HR>
            <p><?php echo $post[$i]['preview'];?><a href="/blog/article/<?php echo $post[$i]['pid'];?>/<?php echo $page;?>.html"> more..</a></p>
          </div>
<?php } ?>
        </div>

        <div class="col-md-4 col-xl-4 hidden-xs">
          <div class="sidebar" role="complementary">
            <div>
              <h3 class="widget-title">Recent Posts</h3>
              <ul>
<?php
$c = count($titles);
for ($i = 0; $i < $c; $i++)
{ ?>
                <li><a href="/blog/article/<?php echo $titles[$i]['pid'];?>"><?php echo $titles[$i]['title'];?></a></li>
<?php } ?>
              </ul>
            </div>
            <div>
              <h3 class="widget-title">Categories</h3>
              <ul>
                <li>Awaiting update</li>
              </ul>
            </div>
<?php if(empty($_SESSION['username'])) { ?>
            <div>
              <h3 class="widget-title">Login</h3>
              <ul>
                <li><a href="login">login</a></li>
                <li><a href="users/register">register</a></li>
              </ul>
            </div>
<?php } ?>
          </div>
        </div>
      </div>
    </div>

<?php } ?>
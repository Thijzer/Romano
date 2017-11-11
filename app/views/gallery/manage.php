<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
?>

<div class="container">
<table class="table table-striped">
  <thead>
    <tr>
      <th>id #</th>
      <th>titel</th>
      <th>datum</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?$c = count($list);for($i=0; $i < $c && $i <= 25; $i++) {?>
    <tr>
      <td>id_<?echo $list[$i]['id']?></td>
      <td><?echo $list[$i]['title']?></td>
      <td><?echo $list[$i]['date']?></td>
      <td><a href="/gallery/edit/<?echo $list[$i]['id']?>">edit</a> /
        <a data-id="<?echo $list[$i]['id']?>" class="del" href="#delete" data-toggle="modal">delete?</a></td>
    </tr>
  <?}?>
  </tbody>
</table>
</div><!-- /end of content container -->

<?php } ?>
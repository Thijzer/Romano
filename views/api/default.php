<?php
function content($data){
extract($data);
?>
<div class="container">
  <form action='' method='post' enctype="multipart/form-data">

    <div class="form-group">
      <label>limit amount</label>
      <input class="form-control" type='text' size='5' name='2' value='<?echo $_POST['2']?>'>
    </div>

    <div class="well">
      <ul>
      <?foreach ($list as $key => $value) {
        ?>
        <li><?echo $key?></li>
      <?}?>
      </ul>
    </div>

    <select>
      <option name="like" value="$_POST['1']">like</option>
      <option name="=" value="$_POST['1']">=</option>
    </select>

    <HR>
      <label>pictures</label>
      <span class="help-block">Pictures helps sales!!</span>
    <div class="row">
      <div class="col-sm-6">
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
      </div>
      <div class="col-sm-6">
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
        <input type="file" name="pics[]"><br>
      </div>
    </div>

    <HR>

    <label>
        <button class="btn btn-primary" name="submit" type="submit">Add Property</button>
    </label>
  </form>
</div>

<?}
function js_after(){
?>

<?}?>
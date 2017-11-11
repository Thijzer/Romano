<?php
class Admin extends Ctrlr
{
  private $view;

  public function __construct()
  {
    $this->view = new View();
    if ($this->_hasAccess(7) !== true) { $this->view->page(1337); }
  }
  public function add($data)
  {
    if (isset($_POST['body'])) {
      if(isset($_POST['tags'])) {
        $tags = $this->_init_('tags');
        $tag = $tags->filterTags($_POST['tags']);
        // if to much changes don't send to mysql and review instead
      }
      $post = $this->_init_('post');
      $post->addPost($tag);
      $pid = $post->getid();
      $tags->storeTags($pid);
    }
    $this->view->render($data);
  }
  public function edit($data)
  {
    $pid = $data['section'][2];
    if(is_numeric($pid)) {
      $post = $this->_init_('post');
      if ($_POST) { // make a comparison vs cached version and look for changes
        $tags = $this->_init_('tags');
        $tag = $tags->filterTags($_POST['tag']);
        $tags->editTags($pid);
        //$post->editPost($pid);
      } else {
        $data['edit'] = $post->getPost($pid);
      }
    }
    $this->view->render($data);
  }

}

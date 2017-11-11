<?php
class Gallery extends Ctrlr
{
  protected $view,$photo;

  function __construct()
  {
  	include (MODEL. 'photo.php');
    $this->view = new View();
    $this->photo = new Photo();
		//define('TMPL',  PROJECT.'template/gallery/');
  }
  function index($data) // shows all public albums // admin sees also non public albums
  {
  	if ($this->_hasAccess(3) === true) {
  		$data['albums'] = $this->photo->getAlbums(array('active' => '1'));
  	} else {
  		$data['albums'] = $this->photo->getAlbums(array('public' => '1', 'active' => '1'));
  	}
  	$this->view->render($data, array('title' =>'Gallery'));
  }
  function album($data) // shows 1 album // public or locked if user is loggedin or has keycode
  {
  	$gid = $data['section'][2];
  	if (!$code = $this->photo->getAccessCodes($gid)) {
  		$this->view->page(404);
  	}
  	if (isset($_POST['code'])) {
  		if ($_POST['keycode'] === $code['keycode']) {
  			$_SESSION['key'] = $code['keycode'];
  			header('Location : '.site.url);
  		} elseif ($_POST['keycode'] === $code['guestcode']) {
  			$_SESSION['key'] = $code['guestcode'];
  			header('Location : '.site.url);
  		} else {
  			unset($_SESSION['key']);
  			$data['msg']['errors'] = 'keycode is not correct';
  		}
  	}
      $data['guesturl'] = site.url.'?guest='.$code['guestcode'];

  	if($_SESSION['key'] === $code['keycode']) {
  		$data['edit'] = site."gallery/select/".$gid;
  		$data['pics'] = $this->photo->getPictures(array('gid' => $gid, 'cust_select' => '1', 'active' => '1'));
  	} elseif ($_SESSION['key'] === $code['guestcode'] OR $_GET['guest'] === $code['guestcode']) {
  		$data['pics'] = $this->photo->getPictures(array('gid' => $gid, 'cust_select' => '1', 'active' => '1'));
    } elseif ($this->_hasAccess(3) === true) {
      $data['pics'] = $this->photo->getPictures(array('gid' => $gid, 'public' => '1', 'active' => '1'));
      $data['edit'] = site."gallery/edit/".$gid;
  	} else {
  		$data['pics'] = $this->photo->getPictures(array('gid' => $gid, 'public' => '1', 'active' => '1'));
  	}
  	$this->view->render($data);
  }
  function picture($data) // shows 1 picture // public or locked if user is loggedin or has keycode
  {
		if ($this->_hasAccess(3) === true OR $_SESSION['key'] == '1') {
  		$data['pic'] = $this->photo->getPicture(array('id' => $data['section'][2],'active' => '1'));
  	} else {
  		$data['pic'] = $this->photo->getPicture(array('id' => $data['section'][2],'active' => '1'));
  	}
  	$this->view->render($data);
  }
  function create($data) // only for admin
  {
  	if ($this->_hasAccess(3) === true) {
	  	if (isset($_POST['create'])) {
	  		$this->photo->savePictures($_FILES['pics']['tmp_name'],$_POST);
	  		die(header('Location: /gallery/manage'));
	  	}
      $this->view->render($data);
  	} else {
      $this->view->page(1337, 'from gallery');
    }
  }
  function manage($data)
  {
  	if ($this->_hasAccess(3) === true) {
	  	$data['list'] = $this->photo->getAlbums();
	  	$this->view->render($data);
  	} else {
  		$this->view->page(1337, 'from gallery');
  	}
  }
  function edit($data)
  {
    if ($this->_hasAccess(3) === true) {
      if (isset($_POST['edit'])) {
        $this->photo->update($data['section'][2],$_POST);
      }
      $data['list'] = $this->photo->editAlbum($data['section'][2]);
      $data['pics'] = $this->photo->editPictures($data['section'][2]);
      $this->view->render($data);
    } else {
      $this->view->page(1337, 'from gallery');
    }
  }
  function select($data)
  {
    if (!$code = $this->photo->getAccessCodes($data['section'][2])) {
      $this->view->page(404);
    }
  	if ($_SESSION['key'] === $code['keycode']) {
    	if (isset($_POST['edit'])) {
    		$this->photo->update($data['section'][2],$_POST,'cust_select');
    	}
    	$data['list'] = $this->photo->editAlbum($data['section'][2]);
    	$data['pics'] = $this->photo->editPictures($data['section'][2]);
    	$this->view->render($data);
    } else {
      $this->view->page(1337, 'from gallery');
    }
  }
}
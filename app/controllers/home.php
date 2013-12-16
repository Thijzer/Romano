<?php
class Home
{
  public function index($data)
  {
    $post = new Post();
    $data['titles'] = $post->getTitles();
    $data['post'] = $post->getPosts();
    View::render($data, array('title' => 'Blog'));
  }
  public function contact($data)
  {
    if (isset($_POST['submit'])) {

      $user = new User();

      if (!$errors  = $user->checkMail($_POST['email'])) {
        $subject    = 'Contact Msg from '.$_POST['name'];
        $body     = "user : ".$_POST['name']."\nemail : ".$_POST['email']."\nhas sent the following message : \n".$_POST['Fmessage'];
        Send::mail('Thijs.dp@gmail.com', $subject, $body);
        $data['msg']['notice'] = "message is sent!"; // $_POST is still active // header with a session msg?
      } else {
        $data['msg']['errors'] = $errors;
      }
    }
    View::render($data);
  }
  public function login($data)
  {
    if ($username = Session::get('username')) {
      $data['msg']['notice'] = 'User  ' . $username . ' is already logged in';
    } elseif (Input::exists() ) {
      $validation = New Validate();
      $validation->check($_POST, array(
        'username' => array('required' => true,'min' => 2,'max' => 20),
        'password' => array('required' => true,'min' => 5)
        ));
      if (!$validation->errors() ) {
        $user = new User;
        if ($login = $user->login(input::get('username'), input::get('password') )) {

          Session::put(array(
            'username' => $login['username'],
            'uid' => $login['uid'],
            'level' => $login['level']));
          exit(header('Location: ' .site.$_SESSION['last']));
        } else {
          $data['msg']['errors'] = 'username or password incorrect';
        }

      } else {
        $data['msg']['errors'] = $validation->errors();
      }
    }
    View::render($data, array('theme' =>'no'));
  }
  public function logout()
  {
    unset($_SESSION['username']);
    unset($_SESSION['level']);
    die(header('Location: ' .site.$_SESSION['last']));
  }
}
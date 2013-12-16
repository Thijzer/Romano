<?php

class Users
{
  public function register($data)
  {
    if (Input::exists()) {  
      $validation = New Validate();
      $validation->check($_POST, array(
        'username' => array(
          'required' => true,
          'min' => 6,
          'max' => 20,
          'db' => array('table' => 'users', 'unique' => true)
        ),
        'password' => array(
          'required' => true,
          'min' => 6
        ),
        'password2' => array(
          'matches' => 'password'
        ),
        'email' => array(
          'required' => true,
          'min' => 2,
          'db' => array('table' => 'users', 'unique' => true)
            
      )));
      if (!$validation->errors() ) {
        $fields = array(
          'username'  => strtolower($validation->getField('username')),
          'password'  => Crypt::toSalt($validation->getField('password')),
          'email'     => $validation->getField('email'),
          'reset'     => Crypt::randomPlus()
        );
        $user = new User();
        $user->register($fields);
        $body     = "Hallo {$fields['username']} and welcome to our site.\n";
        $body    .= "We would like you to confirm your username and registration by activating this link\n\n";
        $body    .= site."users/activate?id={$fields['reset']}&username={$fields['username']}\n\n";
        $body    .= "thank you,\nthe ".title." team.";
        Send::mail($fields['email'], "Confirm you are {$fields['username']}", $body);
        die(header('Location: ' . site . $_SESSION['last']) );
      } else {
        $data['msg']['errors'] = $validation->errors();
      }
    }
    View::render($data, array('theme' => 'no'));
  }
  public function activate($data)
  {
    if (Input::exists('get')) {
      $validation = New Validate();
      $validation->check($_GET, array(
        'username' => array('required' => true),
        'id' => array('required' => true)
      ));
      if (!$validation->errors() ) {
        $user = new User();
        $user->activate($validation->getField('username'), $validation->getField('id') );
        $data['msg']['notice'] = "thank you {$validation->getField('username')}, your account has been activated";
      } else {
        $data['msg']['errors'] = $validation->errors();
      }
    } else {
      $data['msg']['errors'] = 'something went wrong!';
    }
    View::page(200,$data);
  }
}
<?php
/*
* user model, bunch of methods that interacts with the DB
* 
*/
class User
{
  function login($username,$pass)
  {
    return DB::getInstance()->get('users', array(
      'username' => strtolower(trim($username)),
      'password' => Crypt::toSalt($pass),
      'active' => '1'))->fetch();
  }
  function register($array)
  {
    DB::getInstance()->insert('users', $array);
  }
  function activate($username,$code)
  {
    $DB = new DB();
    $DB->query("UPDATE `users` SET `active` = 1, `reset` = null WHERE `username` = '$username' AND `reset` = '$code'");
  }
  function lost($e)
  {
    $url      = site."users/reset/".$this->code;
    $subject    = title.": reset code";
    $body     = "here is your reset code \n".$url."\n\nthank you,\nthe ".title." team";
    $this->db->query("UPDATE `users` SET `reset` = '$this->code' WHERE `email` = '$e'");
    //$this->db->edit('users', array('email' => $this->e))->set('reset' => $this->code);
    sendMail($e, $subject, $body);
  }
  function reset()
  {
    $this->db->query("UPDATE `users` SET `password` = '$this->p', `reset` = null WHERE `uid` = '$this->uid'");
  }
}
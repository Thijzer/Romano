<?php

class Users
{
    private $post;
    private $params = array();

    function __construct()
    {
        $this->route = Container::getAll('route');
        $this->params = $this->route['parameter'];
    }

    public function registerElems($errors = null)
    {
        $form = new Form();
        $form->add('username', array('type' => 'text', 'value' => Input::get('username')));
        $form->add('email', array('type' => 'email', 'value' => Input::get('email')));
        $form->add('email2', array('type' => 'email', 'value' => Input::get('email2')));
        $form->add('password', array('type' => 'password'));

        $view['form'] = $form->parse($errors);
        $view['form']['button'] = Html::elem('input')->type('submit')->name('register')->value('Register')->class('btn btn-lg btn-primary btn-block')->end();
        return $view;
    }

    public function register()
    {
        if (Input::isSubmitted()) {
            $valid = New Validate(Input::getAll());
            $valid->check(
                'username', array('required' => true, 'min' => 6, 'max' => 20,
                'db' => array('table' => 'users', 'unique' => true)
            ));
            $valid->check('password', array('required' => true, 'min' => 6));
            $valid->check(
                'email', array('required' => true, 'min' => 5,
                'db' => array('table' => 'users', 'unique' => true)
            ));
            $valid->check('email2', array('matches' => 'email'));

            if (!$errors = $valid->errors()) {
                $fields = array(
                    'username'  => $valid->get('username'),
                    'password'  => Crypt::toSalt($valid->get('password'), $valid->get('username')),
                    'email'     => $valid->get('email'),
                    'reset'     => Crypt::randomPlus()
                );

                $user = new User;
                $user->register($fields);
                $body = Lang::get('message.register.welcome', array(
                        '{{site}}' => site, '{{title}}' => title,
                        '{{username}}' => $fields['username'],
                        '{{reset}}' => $fields['reset']
                ));

                Send::mail(
                    $fields['email'],
                    Lang::get('title.register.welcome',
                    array('{{username}}' => $fields['username'])),
                    $body
                );

                Output::Redirect($this->route['previous_uri']);
            }
            else return $this->registerElems($errors);
        }
    }

    public function activate()
    {
        if (Input::isSubmitted('get')) {
            $valid = New Validate(Input::getAll());
            $valid->check('username', array('required' => true));
            $valid->check('id', array('required' => true));

            if (!$valid->errors() ) {
                $user = new User;
                $user->activate($valid->get('username'), $valid->get('id') );
                return $view['notice'] = Lang::get('message.activate.ok', array('{{username}}' => $valid->get('username')));
            }
            else return $view['errors'] = $valid->errors();
        }
        else exit(Output::page(1012)); // $view['errors'] = Lang::get('error.incorrect')
    }

    public function login()
    {
        $session = Session::get(config('session', 'name'));
        $userCookie = Cookie::get(config('session','token'));

        if ($session) {
          $results['notice'] = Lang::get('notice.user.loggedin', array(':user' => $session));
          return $results;
        }
        elseif($userCookie) {
            $user = New User;
            $user->checkCookie($userCookie, $this->config);
        }
        return array();
    }

    public function checkLogin()
    {
        if(Input::isSubmitted()) {
            $valid = New Validate($results = Input::getAll());
            $valid->check('username', array('required' => true, 'min' => 2, 'max' => 20));
            $valid->check('password', array('required' => true, 'min' => 5));

            if (!$valid->errors()) {
                $results['input'] = $results;
                $user = new User;
                if ($login = $user->login($valid->get('username'), $valid->get('password'))) {

                    $user->save($login, $this->config);
                    Output::Redirect($this->route['previous_uri']);
                }
            }
            $results['error'] = Lang::get('error.user.incorrect');
            return $results;
        }
    }

    public function logout()
    {
        Session::delete($this->config['session']);
        Session::delete('facebook');
        Output::Redirect($this->route['previous_uri']);
    }

    public function facebook()
    {
        Facebook\FacebookSession::SetDefaultApplication('853714537985997', '73ea32f9db693fd848030e54eb96dd27');
        $fb = new Facebook\FacebookRedirectLoginHelper( site . 'login/fbaccess');

        if (!Session::get('facebook')) {
            $view['loginUrl'] = $fb->getLoginUrl();
            return $view;
        }
        else {
            $user = new User;
            $login = $user->facebookLogin();
            $user->save($login, $this->config);

            Output::Redirect($this->route['previous_uri']);
        }
    }

    public function fbaccess()
    {
        Facebook\FacebookSession::SetDefaultApplication('853714537985997', '73ea32f9db693fd848030e54eb96dd27');
        $fb = new Facebook\FacebookRedirectLoginHelper( site . 'login/fbaccess');

        if($session = $fb->getSessionFromRedirect()) {
            $_SESSION['facebook'] = $session->getToken();
            Output::Redirect('login/facebook');
        }
    }
}

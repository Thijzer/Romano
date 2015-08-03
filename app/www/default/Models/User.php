<?php
/*
* user model, bunch of methods that interacts with the DB
*
*/
class User
{
    static $table = array('users' => 'users');

    function login($user, $pass)
    {
        $user = (string) strtolower(trim($user));
        $pass = (string) trim($pass);

        return DB::run(
            Query::table(self::$table['users'])
                ->where(array(
                    'username' => $user,
                    'password' => Crypt::toSalt($user, $pass),
                    'active' => 1)
                )
            ->build()
        )->fetch();
    }

    function facebookLogin()
    {
        $sessFB = Session::get('facebook');

        try {
            $session = new Facebook\FacebookSession($sessFB);
            $request = new Facebook\FacebookRequest($session, 'GET', '/me');
            $request = $request->execute();
        }
        catch(Facebook\FacebookRequestException $e) {
        }
        catch(\Exception $e) {
        }

        $user = $request->getGraphObject()->asArray();

        $activeUser =  DB::run(
            Query::table(self::$table['users'])
                ->where(array(
                    'facebook_id' => $user['id'],
                    'active' => 1)
                )
            ->build()
        )->fetch();

        if (empty($activeUser)) {

            $newUser = array(
                'facebook_id' => $user['id'],
                'name' => $user['name'],
                'active' => 1
            );

            $userInfo = array(
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'middle_name' => $user['middle_name'],
                'gender' => $user['gender'],
                'timezone' => $user['timezone']
            );

            $q = Query::table(self::$table['users'])->insert($newUser)->build();

            $userInfo['user_id'] = DB::run($q, true)->getInsertedId();
            DB::run(Query::table('_info')->insert($userInfo)->build(), true);

            return $newUser;
        }
        else return $activeUser;
    }

    function register($array)
    {
        DB::run(Query::table(self::$table['users'])->insert($array)->build());
    }

    function activate($user, $code)
    {
        DB::run(
            Query::table(self::$table['users'])
            ->update(array('active' => 1, 'reset' => null))
            ->where(array('username' => $user, 'reset' => $code))
            ->build()
        );
    }

    function lost($e)
    {
        $e = (string) $e;
        $code     = Crypt::randomPlus();
        $url      = site . '/reset/' . $code;
        $subject  = title . ': reset code';
        $body     = 'here is your reset code \n' . $url . '\n\nthank you,\nthe ' . title . ' team';
        //DB::connect()->query("UPDATE `` SET `reset` = '$code' WHERE `email` = '$e'");
        DB::run(
            Query::table(self::$table['users'])
            ->update(array('reset' => $code))
            ->where(array('email' => $e))
            ->build()
        );
        //$this->db->edit('', array('email' => $this->e))->set('reset' => $code);
        sendMail($e, $subject, $body);
    }

    function reset($id, $password)
    {
        DB::run(
            Query::table(self::$table['users'])
            ->update(array('password' => (string) $password, 'reset' => null))
            ->where(array('uid' => (int) $id))
            ->build()
        );
    //DB::connect()->query("UPDATE `` SET `password` = '$this->p', `reset` = null WHERE `uid` = '$this->uid'");
    }

    function save($login, $config)
    {
        $chars = '9876ZSXCFVB543OIUYTNBVCXWFDSMLKJUYTRKJHGFRDVBN';
        $expireDate = time() + $config['cookie']['expire'];
        $token = Crypt::random(10, $chars);

        Auth::saveAccess(
            array(
            'user_id' => $login['id'],
            'api_key' => Crypt::random(20, $chars),
            'token_session' => $token,
            'expire_date' => $expireDate
            )
        );

        Session::set(
            array(
                $config['session']['name'] => $login['username'],
                $config['session']['token'] => $token
            )
        );

        Cookie::set(
            $config['session']['token'],
            array('data' => $token, 'expiry' => $expireDate),
            $expireDate
        );
    }

    function checkCookie($userCookie, $config)
    {
        $id = Auth::getAccess(array('token_session' => $userCookie['data'], 'expire_date' => $userCookie['expiry']));

        if ($id) {
            $login = DB::run( Query::table(self::$table['users'])->where(array('id' => $id))->build() )->fetch();
            $this->save($login, $config);
        }
    }
}

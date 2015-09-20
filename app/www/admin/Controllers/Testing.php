<?php

class Testing
{
    public function urlTest()
    {
        dump(url('home@index'));
        dump( url('js/jquery/jquery.min.js') );
        dump(url('blog@article'));
        dump(url('blog@article', ['ll','ff']));
    }

    public function nr1($app)
    {
        //$app->set('stamp', 'ctrlr', timestamp(2));

        $query = Query::table('')->select(array('username', 'active'))->build();
        //$app->set('stamp', 'query', timestamp(2));

        $results[''] = DB::run($query)->fetch();
        //$app->set('stamp', 'DB', timestamp(2));

        $query = Query::table('posts')->select(array('title', 'active', 'date', 'id'))->build();
        //$app->set('stamp', 'query2', timestamp(2));

        $results['post'] = DB::run($query)->fetchAll();

        $start = timestamp(2);
        for ($i=0; $i < 5; $i++) {
            $q1 = Query::table('house')->save(array('title' => 'no', 'active' => 1, 'date' => 1234, 'id' => 34))->build();
        }
        $app->set('stamp', 'test_end', timestamp(2) - $start);

        // $start = timestamp(2);
        // for ($i=0; $i < 3; $i++) {
        //     // $b = Query::table('house')->slowInsert(array('title', 'active', 'date', 'id'))->build();
        // }
        // $app->set('stamp', 'test_end2', timestamp(2) - $start);

        return $results;
    }

    public function get($app)
    {
        $rand = '9876ZSXCFVB543OIUYTNBVCXWFDSMLKJUYTRKJHGFRDVBN';

        $q4 = Query::table('auth')
            ->save(array(
                'user_id' => 2,
                'api_key' => Crypt::random(20, $rand),
                'token_session' => Crypt::random(10, $rand),
                'expire_date' => time() + 2588400),
                'user_id')
            ->build();

        dump($q4);

        //echo strtotime( '+30 days') - time();

        $q = Query::table('')
            ->where(array(
                'username' => strtolower(trim('thijzer')),
                'password' => Crypt::toSalt('thijzer', 'yelgre'),
                'active' => 1))
            ->build();

        dump($q);

        $q1 = Query::table('posts')->where(array('title' => 'Hello brave world'))->build();
        $q2 = Query::table('')->settings(array('namedParams' => false))->where(array('active' => 1))->build();
        //dump($q1);dump($q2);dump($q); dump($q4);//exit();

        //$results['insert'] = DB::run( $q3 );
        $results['login'] = DB::run( $q )->fetch();
        $results['post'] = DB::run( $q1 )->fetchAll();
        $results[''] = DB::run( $q2 )->fetchAll();
        DB::run( $q4, true );
        return $results;
    }

    public function nr3($app)
    {
        $results['post'] = DB::run(Query::table('posts')
            ->select(array('title', 'active','date', 'id'))
            ->build()
        )->fetchAll();

        return $results;
    }

    public function app($app)
    {
        echo( Crypt::random(12) );
        $results['post'] = DB::run(Query::table('posts')
            ->select(array('title', 'active','date', 'id'))
            ->build()
        )->fetchAll();

        return $results;
    }

    public function save_user($app)
    {
        $rand = '9876ZSXCFVB543OIUYTNBVCXWFDSMLKJUYTRKJHGFRDVBN';
        $q = Query::table('auth')
        ->save(array(
            'user_id' => 2,
            'api_key' => Crypt::random(20, $rand),
            'token_session' => Crypt::random(10, $rand),
            'expire_date' => time() + 2588400), 'user_id')
        ->build();
        DB::run( $q, true );

        return $results;
    }

    public function grab($app)
    {
        $results = Parse::json('http://blog.dev/testing/nr3.json');
        $app->set('stamp', 'ctrlr', timestamp(2));
        return $results;
    }

    public function form($app)
    {
        if ($app->get(array('route', 'view')) === 'twig') View::twig('index.twig', array('content' => $results));
        return $results;
    }

    public function Crypt($app)
    {
        echo Crypt::toSalt('thijzer', 'thijzer');
        //echo Crypt::random(4, '9876ZSXCFVB543OIUYTNBVCXWFDSMLKJUYTRKJHGFRDVBN');
        //echo $ab = '<BR>' . 'thijzer' . 'yelgre'. '<BR>';
        if (!empty($ab)) echo hash('sha256', md5($ab) );
    }
}

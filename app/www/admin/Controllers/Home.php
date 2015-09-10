<?php

class Home
{
    function index()
    {
    }

    function elastic()
    {
        $object = array('color' => 'red');
        $ES = new Elastic();
        //$ES->init('test', 'helloworld')->store($object, '1')->refresh();

        //Elastic::init('test', 'helloworld')->bulkStore($object, $id)->refresh();
        // store
        //echo timestamp(2) . "/n";
        //$client = new \Elastica\Client();
        //$index = $client->getIndex('test');
        //$index->create(array(), true);
        //$type = $index->getType('helloworld');
        // // foreach items
        //$type->addDocument(new \Elastica\Document(1, array('color' => 'red')));
        // $type->addDocument(new \Elastica\Document(2, array('color' => 'green')));
        //$type->addDocument(new \Elastica\Document(3, array('color' => 'blue')));
        //$index->refresh();

        $bam = $ES->init('test', 'helloworld')->search($object, 'test')->getResults();

        echo($bam);exit;

        // // search
        // $client = new \Elastica\Client();
        // $type = $client->getIndex('test')->getType('helloworld');echo timestamp(2) . "/n"; // 6ms
        //

        // $filter = new \Elastica\Filter\Term(array('color' => 'red'));

        // $facet = new \Elastica\Facet\Filter('test');echo timestamp(2) . "/n";
        // $facet->setFilter($filter);
        // $query = new \Elastica\Query();echo timestamp(2) . "/n";
        // $query->addFacet($facet);
        //
        // // get the result should be done only o
        // $resultSet = $type->search($query);echo timestamp(2) . "/n"; //10ms
        //
        // // gets all the facets
        // $facets = $resultSet->getFacets();
        // //$elasticaSearchResult = $type->search($query);
        // $elasticaResults = $resultSet->getResults(); // all results
        //
        // // build the array
        // foreach ($elasticaResults as $elasticaResult) {
        //     $results[] = $elasticaResult->getData();
        // }
        //
        // dump( $results );
        //
        // echo timestamp(2) .  "/n";

        // exit;
        //$post = New Post();
        //$result['posts'] = $post->getPosts();

        //$elasticaClient = new \Elastica\Client();
        //$elasticaIndex = $elasticaClient->getIndex('tracker');
        //$elasticaType = $elasticaIndex->getType('tweet');
        //$elasticaQueryString = new \Elastica\Query\QueryString();
        //$elasticaQueryString->setParam('env', 'local');
        //$elasticaQuery = new \Elastica\Query();
        //$elasticaQuery->setQuery($elasticaQueryString);
        //$resultSet = $elasticaType->search($elasticaQuery);
        //$count = $resultSet->count();

        //$type = $elasticaIndex->getType('tweet');

        // Perform Search
        //$resultSet = $elasticaIndex->search('env');

        // Get IDs
        // $resultIDs = array();
        // foreach($resultSet as $result){
        //     $resultIDs[] = $result->getId();
        // }
        // dump($resultIDs);
        //exit;

        // $elasticaResultSet = $elasticaIndex->search($elasticaQuery);
        //
        // $elasticaResults = $elasticaResultSet->getResults();
        // $totalResults = $elasticaResultSet->getTotalHits();
        //
        // foreach ($elasticaResults as $elasticaResult) {
        //     var_dump($elasticaResult->getData());
        // }
        // exit;

        $result['path'] = $this->route['path'];
        $this->global['date'] = date('now'); // not passing
        $this->meta['description'] = 'yeah baby!'; // not passing because meta in ctrl
        return $result;
    }

    function add()
    {

    }

    function edit()
    {

    }

    function delete()
    {

    }
}

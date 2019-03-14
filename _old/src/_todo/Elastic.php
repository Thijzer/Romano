<?php



use \Elastica\Client as client;
use \Elastica\Filter\Term as term;
use \Elastica\Facet\Filter as filter;
use \Elastica\Document as document;
use \Elastica\Query as query;

Class Elastic
{
    public $facet;
    //$client = new client();
    //$index = $client->getIndex('test');
    //$index->create(array(), true);
    //$type = $index->getType('helloworld');
    // foreach items
    //$type->addDocument(new document(1, array('color' => 'red')));
    // $type->addDocument(new document(2, array('color' => 'green')));
    //$type->addDocument(new document(3, array('color' => 'blue')));
    //$index->refresh();

    // get the result should be done only ones
    //$resultSet = $type->search($query);echo timestamp(2) . "/n"; //10ms

    // gets all the facets
    //$facets = $resultSet->getFacets();
    //$elasticaSearchResult = $type->search($query);

    function __construct()
    {
        $this->client = new client();
    }

    public function init($index = null, $type = null)
    {
        if(!$index || !$type) return false;

        $this->index = $this->client->getIndex($index);
        //$this->index->create(array(), true);
        $this->type = $this->index->getType($type);
        return $this;
    }

    public function store($item, $id = null)
    {
        // if($id === null || is_array($item)) exit($id);
        $this->type->addDocument(new document($id, $item));
        return $this;
    }

    public function bulkStore(array $items, $id)
    {
        foreach ($items as $key => $item)
        {
            $this->type->addDocument(new document($key, $item));
        }
        return $this;
    }

    public function refresh()
    {
        $this->index->refresh();
    }

    /// here we try to search the things we need

// $filter = new \Elastica\Filter\Term(array('color' => 'red'));

// $facet = new \Elastica\Facet\Filter('test');echo timestamp(2) . "/n";

    public function search($term, $filtr = null)
    {
        //$this->filter = new term($term);

        if(!$this->facet) {
            $this->filterType($filtr);
        }

        $this->facet->setFilter(new term($term));

        if(!$this->query) $this->query = new query();

        $this->addFacet($this->facet);

        return $this;
    }

    // set the filter type
    public function filterType(string $filtr)
    {
        $this->facet = new filter($filtr);
        return $this;
    }

    public function addFilter(string $filtr)
    {
        $this->facet->setFilter($filtr);
        return $this;
    }

    public function addFacet($facet)
    {
        $this->query->addFacet($facet);
        return $this;
    }

    // from here we need a searchable query at minimum

    // te slow part only in the
    // last part of the array should it be envoked
    public function get()
    {
        $this->results = $type->search($this->query);
        return $this;
    }

    // build the array
    public function results()
    {
        foreach ($this->results->getResults() as $elasticaResult) {
            $results[] = $elasticaResult->getData();
        }
        return $results;
    }

    // counter
    public function totalHits()
    {
        return $this->results->getTotalHits();
    }
}

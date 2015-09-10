<?php

class Timer
{
    function getAllProjects()
    {
        return DB::run(Query::table('projects')->build())->fetchAllBy('id');
    }

    function getAllPhases()
    {
        return DB::run(Query::table('phases')->build())->fetchPairs('id', 'name');
    }

    function getAllCompanies()
    {
        return DB::run(Query::table('companies')->build())->fetchPairs('id', 'name');
    }

    function getAllTasksFromProjects($projectIds)
    {
        $ids = '('. implode(',', $projectIds) . ')';
        $q = Query::table('project_tasks')
        ->where(array('id' => $ids))
        ->build();

        //dump($q);exit;

        return DB::run($q

        )->fetch();
    }
}

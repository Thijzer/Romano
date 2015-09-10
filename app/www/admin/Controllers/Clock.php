<?php

class Clock extends Ctrlr
{
    function construct()
    {
        $this->timer = new Timer();
    }
    function index()
    {
    }

    function addTime()
    {
        $result['projects'] = $this->timer->getAllProjects(); // all recent Projects
        dump($result);exit;
        $result['tasks'] = $this->timer->getAllTasksFromProjects($result['projects']); // list of all tasks in groups of projects
        return $result;
    }

    function addProject()
    {

    }

    function edit()
    {

    }

    function delete()
    {

    }
}

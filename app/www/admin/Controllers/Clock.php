<?php

class Clock extends Ctrlr
{
    function construct()
    {
        $this->timer = new Timer();
    }
    function index()
    {
      dump('D');
      exit;
    }

    function addTime()
    {
        //$result['projects'] = $this->timer->getAllProjects(); // all recent Projects
        //$result['tasks'] = $this->timer->getAllTasksFromProjects($result['projects']); // list of all tasks in groups of projects
        //return $result;s
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

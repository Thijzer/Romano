<?php

class Projects extends Ctrlr
{
    function __construct()
    {
        $this->timer = new Timer();
    }
    function newProject()
    {
      $result['companies'] = $this->timer->getAllCompanies();
      $input = new Input();

        if ($input->isSubmitted('submit')) {

            $errors = '';

            if (!$errors) {
                $input->get('project_name');
            }

        }
        return $result;
    }

    function addTime()
    {
        $result['companies'] = $this->timer->getAllCompanies(); // all phases
        $result['phases'] = $this->timer->getAllPhases(); // all phases
        $result['projects'] = $this->timer->getAllProjects(); // all recent Projects for ddm
        $result['tasks'] = $this->timer->getAllTasksFromProjects(array_keys($result['projects'])); // list of all tasks in groups of projects
        dump($result);exit;

        //return $result;
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

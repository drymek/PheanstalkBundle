<?php

namespace drymek\PheanstalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class JobController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render();
    }

    public function deleteAction($name, $job_id) {
        $pheanstalk = $this->get('pheanstalk');
        $job = $pheanstalk->peek($job_id);
        $pheanstalk->delete($job);

        return $this->redirect($this->generateUrl('drymekPheanstalkBundle_tubejobs', array('name' => $name)));
    }
}

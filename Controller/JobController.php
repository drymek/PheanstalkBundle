<?php

namespace drymek\PheanstalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use drymek\PheanstalkBundle\Entity\Job;
use drymek\PheanstalkBundle\Form\JobType;


class JobController extends Controller
{
    const TIMEOUT = 3;
    
    public function indexAction($name)
    {
        $pheanstalk = $this->get('pheanstalk');
        $pheanstalk->watch($name)
            ->ignore('default');

        $jobs = array();
        while (true) {
            $job = $pheanstalk->reserve(self::TIMEOUT);
            if (false === $job) {
                break;
            }
            else {
                $jobs[] = $job;
            }
        }
        
        foreach ($jobs as $job)
        {
            $pheanstalk->release($job);
        }

        return $this->render('drymekPheanstalkBundle:Job:index.html.twig', array(
            'jobs' => $jobs,
            'name' => $name,
        ));
    }

    public function putAction($name)
    {
        $pheanstalk = $this->get('pheanstalk');
        $pheanstalk->useTube($name);
        

        $job = new Job();

        $form = $this->createForm(new JobType(), $job);
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $pheanstalk->put($job->getData());
                return $this->redirect($this->generateUrl('drymekPheanstalkBundle_tubejobs', array('name' => $name)));
            }
        }
        return $this->render('drymekPheanstalkBundle:Job:put.html.twig', array(
            'form' => $form->createView(),
            'name' => $name,
        ));
    }


    public function deleteAction($name, $job_id) {
        $pheanstalk = $this->get('pheanstalk');
        $job = $pheanstalk->peek($job_id);
        $pheanstalk->delete($job);

        return $this->redirect($this->generateUrl('drymekPheanstalkBundle_tubejobs', array('name' => $name)));
    }
}

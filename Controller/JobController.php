<?php

namespace drymek\PheanstalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use drymek\PheanstalkBundle\Entity\Job;
use drymek\PheanstalkBundle\Form\JobType;

/**
 * Job Controller 
 * 
 * @uses Controller
 * @package PheanstalkBundle
 * @author Marcin Dryka <marcin@dryka.pl> 
 */
class JobController extends Controller
{
    /**
     *  Pheanstal timeout
     */
    const TIMEOUT = 3;
    
    /**
     * indexAction List jobs for given tube
     * 
     * @param string $name Tube name
     */
    public function indexAction($name)
    {
        $pheanstalk = $this->get('pheanstalk');
        $pheanstalk->watch($name);
        if ('default' !== $name) {
            $pheanstalk->ignore('default');
        }

        // List tube jobs workaround
        $jobs = array();
        // Read jobs until there is nothing in the tube
        while (true) {
            $job = $pheanstalk->reserve(self::TIMEOUT);
            if (false === $job) {
                break;
            }
            else {
                $jobs[] = $job;
            }
        }

        // And than release all jobs back to tube.
        foreach ($jobs as $job) {
            $pheanstalk->release($job);
        }

        return $this->render('drymekPheanstalkBundle:Job:index.html.twig', array(
            'jobs' => $jobs,
            'name' => $name,
        ));
    }

    /**
     * putAction Put new job to given tube (form and submit)
     * 
     * @param string $name Tube name
     */
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

    /**
     * deleteAction Delete job and back to jobs list
     * 
     * @param string $name Tube name
     * @param integer $job_id Job id
     */
    public function deleteAction($name, $job_id) 
    {
        $pheanstalk = $this->get('pheanstalk');
        $job = $pheanstalk->peek($job_id);
        $pheanstalk->delete($job);

        return $this->redirect($this->generateUrl('drymekPheanstalkBundle_tubejobs', array('name' => $name)));
    }
}

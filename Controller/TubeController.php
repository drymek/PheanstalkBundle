<?php

namespace drymek\PheanstalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pheanstalk\Exception\ServerException;
use drymek\PheanstalkBundle\Entity\Job;
use drymek\PheanstalkBundle\Form\JobType;


class TubeController extends Controller
{
    const TIMEOUT = 5;
    public function indexAction()
    {
        $pheanstalk = $this->get('pheanstalk');
        $tubes = $pheanstalk->listTubes();
        return $this->render('drymekPheanstalkBundle:Tube:index.html.twig', array(
            'tubes' => $tubes,
        ));
    }

    public function showAction($name)
    {
        $pheanstalk = $this->get('pheanstalk');
        $pheanstalk->useTube($name);

        try
        {
            $stats = $pheanstalk->statsTube($name);
        }
        catch (ServerException $e)
        {
            throw $this->createNotFoundException('The tube does not exist');
        }
        return $this->render('drymekPheanstalkBundle:Tube:show.html.twig', array(
            'stats' => $stats,
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
                $pheanstalk->put($job->getContent());
                return $this->redirect($this->generateUrl('drymekPheanstalkBundle_tubeshow', array('name' => $name)));
            }
        }
        return $this->render('drymekPheanstalkBundle:Tube:put.html.twig', array(
            'form' => $form->createView(),
            'name' => $name,
        ));
    }

    public function jobsAction($name)
    {
        $pheanstalk = $this->get('pheanstalk');
        $pheanstalk->useTube($name);

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

        return $this->render('drymekPheanstalkBundle:Tube:jobs.html.twig', array(
            'jobs' => $jobs,
            'name' => $name,
        ));
    }
}

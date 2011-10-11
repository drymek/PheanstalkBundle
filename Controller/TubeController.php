<?php

namespace drymek\PheanstalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pheanstalk\Exception\ServerException;
use drymek\PheanstalkBundle\Entity\Tube;
use drymek\PheanstalkBundle\Form\TubeType;


class TubeController extends Controller
{
    public function indexAction()
    {
        $pheanstalk = $this->get('pheanstalk');
        $tubes = $pheanstalk->listTubes();
        return $this->render('drymekPheanstalkBundle:Tube:index.html.twig', array(
            'tubes' => $tubes,
        ));
    }

    public function createAction()
    {
        $tube = new Tube();

        $form = $this->createForm(new TubeType(), $tube);
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $pheanstalk = $this->get('pheanstalk');
                $pheanstalk->useTube($tube->getName());
                $pheanstalk->put('create-tube-job');
                return $this->redirect($this->generateUrl('drymekPheanstalkBundle_tube'));
            }
        }
        return $this->render('drymekPheanstalkBundle:Tube:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function tubeStatsAction($name)
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
        return $this->render('drymekPheanstalkBundle:Tube:tubeStats.html.twig', array(
            'stats' => $stats,
        ));
    }

    public function serverStatsAction()
    {
        $pheanstalk = $this->get('pheanstalk');
        $stats = $pheanstalk->stats();

        return $this->render('drymekPheanstalkBundle:Tube:serverStats.html.twig', array(
            'stats' => $stats,
        ));
    }
}

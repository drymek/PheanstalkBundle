<?php

namespace drymek\PheanstalkBundle\Entity;

/**
 * Job entity
 * 
 * @package PheanstalkBundle
 * @author Marcin Dryka <marcin@dryka.pl> 
 */
class Job
{
    /**
     * job data
     * @var string
     */
    protected $data;

    /**
     * getData 
     * 
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * setData 
     * 
     * @param string $data 
     * @return void
     */
    public function setData($data)
    {
        $this->data = (string)$data;
    }
}

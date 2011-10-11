<?php

namespace drymek\PheanstalkBundle\Entity;

/**
 * Tube 
 * 
 * @package PheanstalkBundle
 * @author Marcin Dryka <marcin@dryka.pl> 
 */
class Tube
{
    /**
     * tube name 
     * @var string
     */
    protected $name;

    /**
     * getName 
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName 
     * 
     * @param string $name 
     * @return void
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }
}

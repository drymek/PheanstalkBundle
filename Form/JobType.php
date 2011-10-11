<?php

namespace drymek\PheanstalkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * JobType 
 * 
 * @uses AbstractType
 * @package PheanstalkBundle
 * @author Marcin Dryka <marcin@dryka.pl> 
 */
class JobType extends AbstractType
{
    /**
     * buildForm 
     * 
     * @inheritdoc
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('data');
    }

    /**
     * getName 
     * 
     * @inheritdoc
     */
    public function getName()
    {
        return 'job';
    }
}

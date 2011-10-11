<?php

namespace drymek\PheanstalkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * TubeType 
 * 
 * @uses AbstractType
 * @package PheanstalkBundle
 * @author Marcin Dryka <marcin@dryka.pl> 
 */
class TubeType extends AbstractType
{
    /**
     * buildForm 
     * 
     * @inheritdoc
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
    }

    /**
     * getName 
     * 
     * @inheritdoc
     */
    public function getName()
    {
        return 'tube';
    }
}

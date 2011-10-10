<?php

namespace drymek\PheanstalkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class JobType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('content');
    }

    public function getName()
    {
        return 'job';
    }
}

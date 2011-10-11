## Introduction:

Pheanstalk bundle is simple and easy way to use Pheanstalk2 (namespaced version of Pheanstalk) with Symfony2 applications. It's provide some usefull tool.

## Install:

deps:

```
[Pheanstalk]
    git=https://github.com/mrpoundsign/pheanstalk.git
    target=/pheanstalk

[drymekPheanstalkBundle]
    git=https://github.com/drymek/PheanstalkBundle.git
    target=/bundles/drymek/PheanstalkBundle
```

app/AppKernel.php

```
        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            // (...)
            $bundles[] = new drymek\PheanstalkBundle\drymekPheanstalkBundle();
        }
```

app/autoload.php

```

$loader->registerNamespaces(array(
    // (...)
    'Pheanstalk'       => __DIR__.'/../vendor/pheanstalk/classes',
    'drymek'           => __DIR__.'/../vendor/drymek',
));

```

## Service:

Get the Pheanstalk object to work with:

```
$this->get('pheanstalk');
```

## Developers tools:

Add to your app/config/routing_dev.yml

```
_pheanstalk:
    resource: "@drymekPheanstalkBundle/Resources/config/routing.yml"
    prefix:   /_pheanstalk
```

## Developers tools features:

* List tubes 
* Create tube
* List tube's jobs
* Delete jobs
* Put new job to tube

## Usage example:

```
$pheanstalk = $this->get('pheanstalk');

// ----------------------------------------
// producer (queues jobs)

$pheanstalk
    ->useTube('testtube')
    ->put("job payload goes here\n");

// ----------------------------------------
// worker (performs jobs)

$job = $pheanstalk
    ->watch('testtube')
    ->ignore('default')
    ->reserve();

echo $job->getData();

$pheanstalk->delete($job);
```

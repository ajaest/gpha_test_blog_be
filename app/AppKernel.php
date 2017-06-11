<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            # Framework library
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            # Security and authorization firewall
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            # Templating library
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            # Logging library
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            # Mailer library. Needed by FOS\UserBundle\FOSUserBundle
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            # ORM
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            # Annotation and utilities
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            # CORS support
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            # User entities and logic
            new FOS\UserBundle\FOSUserBundle(),
            # OAuth library
            #new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            # Serializer library. Must be before FOS\RestBundle\FOSRestBundle
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            # REST API Library
            new FOS\RestBundle\FOSRestBundle(),

            # CUSTOM Oauth entities, server & client
            new AuthorizationBundle\AuthorizationBundle(),

            # CUSTOM blog logic
            new BlogBundle\BlogBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}

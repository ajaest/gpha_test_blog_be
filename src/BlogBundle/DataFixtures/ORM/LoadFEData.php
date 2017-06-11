<?php

namespace BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AuthorizationBundle\Entity\Client;
use AuthorizationBundle\Entity\User;

class LoadFEData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $frontendApp = new Client();
        $frontendApp->setName('Frontend app at localhost:8888');
        $frontendApp->setRandomId('3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4');
        $frontendApp->setSecret('4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k');
        $frontendApp->setRedirectUris(array(
            # redirect_uri=>'http://localhost:8888/oauth2/login'
        ));
        $frontendApp->setAllowedGrantTypes(array(
            'password'
        ));

        $manager->persist($frontendApp);

        # Create a user
        $userAdmin = new User();
        $userAdmin->setUsername('admin@example.com');
        $userAdmin->setEmail('admin@example.com');
        $userAdmin->setEnabled(True);
        $userAdmin->setPlainPassword('test');

        $manager->persist($userAdmin);

        $manager->flush();
    }
}
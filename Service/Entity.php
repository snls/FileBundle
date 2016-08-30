<?php
/**
 * Created by PhpStorm.
 * User: lookyalba
 * Date: 30.08.16
 * Time: 12:25
 */

namespace FileBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class Entity
{
    protected $em;
    protected $container;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }
    
    public function persist($object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }
}
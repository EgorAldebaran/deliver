<?php  

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

abstract class ServiceEntityContainerAbstract
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    abstract public function getInstance();

    /**
     * @return ObjectRepository
     */
    abstract public function getRepository();

    /**
     * @return $this
     */
    public function flush()
    {
        $this->entityManager->flush();
        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}

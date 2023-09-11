<?php  

namespace App\Service;

use App\Entity\CalcDelivery;
use App\Service\ServiceEntityContainerAbstract;

class CalcDeliveryService extends ServiceEntityContainerAbstract
{
    /**
    * @return CalcDelivery 
    */
    public function getInstance(): CalcDelivery
    {
        $instance = new CalcDelivery;
        $this->entityManager->persist($instance);
        return $instance;
    }

    /**
    * @return CalcDeliveryRepository 
    */
    public function getRepository(): CalcDeliveryRepository
    {
        return $this->entityManager -> getRepository(CalcDelivery::class)->findAll();
    }

    /**
    * @return price 
    */
    
}

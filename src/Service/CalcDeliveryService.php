<?php  

namespace App\Service;

use App\Entity\CalcDelivery;
use App\Service\ServiceEntityContainerAbstract;

class CalcDeliveryService extends ServiceEntityContainerAbstract
{
    /// базовая константа для расчета цена * вес товара
    public const BASE_VALUE = 200.00;

    /// значение каждого дня для цены, например, каждый день
    /// посылка становится дороже на 5%
    public const WEIGHT_DAY = 1.05;

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
     * @param int $numbers_days
     * @param int $weight  
     * @return float $totalPrice 
     */
    public function calcPrice(int $weight, int $numbers_days): float
    {
        $price = (float)self::BASE_VALUE * $weight;
        $totalPrice = (float)self::WEIGHT_DAY * $numbers_days * $price;
        return $totalPrice;
    }

    
    
}

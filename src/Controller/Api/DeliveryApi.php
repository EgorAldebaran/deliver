<?php  

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalcDeliveryService;

class DeliveryApi extends AbstractController
{
    public const BASE_VALUE = 100;

    /**
    * @var base_url: string
    * @var sourceKladr string //кладр откуда везем
    * @var targetKladr string //кладр куда везем
    * @var weight float //вес отправления в кг
    * 
    * @return json
    * {
    *   'coefficient': float //коэффициент (конечная цена есть произведение
    *   'date': string //дата доставки в формате 2017-10-20
    *   'error': string
    * }
    */
    #[Route('api/slow-delivery', name: 'slow_delivery')]
    public function slowDelivery(Request $request, CalcDeliveryService $calcDelivery, EntityManagerInterface $entityManager): Response
    {
        $errors = 'success';
        $delivery = $calcDelivery->getInstance();
        $dateString = date('Y-m-d');
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);

        $content = $request->getContent();

        
    }
    
    #[Route('api/delivery', name: 'delivery_api')]
    public function delivery(Request $request, CalcDeliveryService $calcDelivery, EntityManagerInterface $entityManager): Response
    {
        $errors = 'success';
        $delivery = $calcDelivery->getInstance();
        $dateString = date('Y-m-d');
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        
        $content = $request->getContent();
        
        $price = $calcDelivery->calcPriceForQuickDelivery
               (
                   json_decode($content, true)["weight"],
                   json_decode($content, true)["period"]
               )
               ;

        if (!$price) {
            $errors = "price is null. Something wrong!";
        }
        
        $delivery->setPrice($price);
        $delivery->setPeriod(1000);
        $delivery->setCoefficient(10.10);
        $delivery->setDate($date);
        $delivery->setError('success');

        $entityManager->persist($delivery);
        $entityManager->flush();

        $json = [
            "price" => $price,
            "period" => 4,
            "errors" => $errors,
        ];
        
        $jsonContent = json_encode($json);
        
        return new Response($jsonContent);
    }

}

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
    
    #[Route('api/delivery', name: 'delivery_api')]
    public function delivery(Request $request, CalcDeliveryService $calcDelivery, EntityManagerInterface $entityManager): Response
    {
        $delivery = $calcDelivery->getInstance();
        $dateString = date('Y-m-d');
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        
        $content = $request->getContent();

        $price = self::BASE_VALUE * json_decode($content, true)["weight"];
        
        $delivery->setPrice($price);
        $delivery->setPeriod(1000);
        $delivery->setCoefficient(10.10);
        $delivery->setDate($date);
        $delivery->setError('success');

        $entityManager->persist($delivery);
        $entityManager->flush();
        
        $jsonContent = json_encode($price . ' success');
        
        
        return new Response($jsonContent);
    }

}

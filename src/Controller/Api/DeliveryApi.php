<?php  

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalcDeliveryService;
use App\Entity\CalcDelivery;

class DeliveryApi extends AbstractController
{
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
        if (json_decode($content, true)["sourceKladr"] == NULL) {
            $errors = "path from destination cannot be null";
        }
        if (json_decode($content, true)["targetKladr"] == NULL) {
            $errors = "path target destination cannot be null";
        }

        $coefficient = $calcDelivery->calcCoefficient
                     (
                         CalcDelivery::BASE_VALUE,
                         json_decode($content, true)["weight"],
                     )
                     ;
        if (!$coefficient) {
            $errors = "coefficient is null. Something wrong!";
        }

        $json = [
            "coefficient" => $coefficient,
            "data" => $date,
            "errors" => $errors,
        ];

        $jsonContent = json_encode($json);

        return new Response($jsonContent);
    }


    /**
    * @var base_url: string
    * @var sourceKladr string //кладр откуда везем
    * @var targetKladr string //кладр куда везем
    * @var weight float //вес отправления в кг
    * @return json 
    *  {
    *  'price' : float
    *  'period'  int // количество дней начиная с сегодняшнего, но после 18.00 заявки не принимаются
    *  'error':string
    *  }
    */
    #[Route('api/quick-delivery', name: 'delivery_api')]
    public function quickDelivery(Request $request, CalcDeliveryService $calcDelivery, EntityManagerInterface $entityManager): Response
    {
        $errors = 'success';
        $delivery = $calcDelivery->getInstance();
        $dateString = date('Y-m-d');
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        
        $content = $request->getContent();

        if (json_decode($content, true)["sourceKladr"] == NULL) {
            $errors = "path from destination cannot be null";
        }

        if (json_decode($content, true)["targerKladr"] == NULL) {
            $errors = "path from target destination cannot be null";
        }


        $period = json_decode($content, true)["period"];
        
        $price = $calcDelivery->calcPriceForQuickDelivery
               (
                   json_decode($content, true)["weight"],
                   $period,
               )
               ;

        if (!$price) {
            $errors = "price is null. Something wrong!";
        }
        
        $delivery->setPrice($price);
        $delivery->setPeriod($period);
        $delivery->setCoefficient(10.10);
        $delivery->setDate($date);
        $delivery->setError('success');

        $entityManager->persist($delivery);
        $entityManager->flush();

        $json = [
            "price" => $price,
            "period" => $period,
            "errors" => $errors,
        ];
        
        $jsonContent = json_encode($json);
        
        return new Response($jsonContent);
    }

}

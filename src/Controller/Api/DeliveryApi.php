<?php  

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryApi extends AbstractController
{
    #[Route('api/delivery', name: 'delivery_api')]
    public function delivery(Request $request): Response
    {
        $content = $request->getContent();
        $content = 'duck the system'; 
        return new Response($content);
    }
}

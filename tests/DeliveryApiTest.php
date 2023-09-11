<?php  

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contract\HttpClient\HttpClientInterface;
use App\Service\CalcDeliveryService;

class DeliveryApiTest extends KernelTestCase
{
    public const PATH = 'http://localhost/api/delivery';

    /**
    * @var ContainerInterface
    */
    protected $container;

    /**
    * @var HttpClientInterface
    */
    protected $client;

    /**
    * @var CalcDeliveryService
    */
    protected $deliveryService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->container = static::getContainer();
        $this->client = $this->container->get('http_client');
        $this->deliveryService = $this->container->get('my_service');
    }

    public function testService()
    {
        $weight = 5;
        $numbers_days = 4; 
        $result = $this->deliveryService->calcPrice($weight, $numbers_days);
        $this->assertEquals($result, 4.2 * 200.00 * 5);
    }

    public function testApi()
    {
        $quickDelivery = [
            'base_url' => 'http://QuickDelivery.com',
            'sourceKladr' => 'Kazahstan city Astana Street 10',
            'targerKladr' => 'Kazahstan city Astana Street 20',
            'weight' => 99.10,
            'period' => 4,
        ];

        $response = $this->client->request(
            'POST',
            self::PATH,
            [
                'json' => $quickDelivery,
            ],
        );

        $content = $response->getContent();
        $this->assertNotEmpty($content);

        echo "\n" . $content;
    }
}

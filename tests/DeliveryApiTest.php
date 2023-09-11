<?php  

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contract\HttpClient\HttpClientInterface;

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

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->container = static::getContainer();
        $this->client = $this->container->get('http_client');
    }

    public function testApi()
    {
        $quickDelivery = [
            'base_url' => 'http://QuickDelivery.com',
            'sourceKladr' => 'Kazahstan city Astana Street 10',
            'targerKladr' => 'Kazahstan city Astana Street 20',
            'weight' => 99.10,
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

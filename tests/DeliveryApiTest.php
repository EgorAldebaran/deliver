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
        $fakeData = [
            'jacke' => 'diamonds',
            'queen' => 'hearts',
        ];

        $response = $this->client->request(
            'POST',
            self::PATH,
            [
                'json' => $fakeData,
            ],
        );

        $content = $response->getContent();
        $this->assertNotEmpty($content);

        echo "\n" . $content;
    }
}

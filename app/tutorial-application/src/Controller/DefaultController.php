<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use DateTime;

class DefaultController extends AbstractController
{
    public function indexAction()
    {
        $client = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);

        $cacheEntryIdentifier = "cache-entry";

        $cachedData = $client->get($cacheEntryIdentifier);
        
        if ($cachedData != null) {
            $json = base64_decode($cachedData);
            $response = new Response($json);
            $response->headers->set('Content-Type', 'text/json');

            return $response;
        }

    	$cars = $this->getDoctrine()
        ->getRepository(Car::class)
        ->findAll();

        $now = new DateTime();

        $carData = [];
        $carData['total'] = count($cars);
        $carData['time'] = $now->format('Y-m-d H:i:s');

        foreach ($cars as $car) {
        	$carResponse = [];
        	$carResponse['numberOfDoors'] = $car->getNumberOfDoors();
        	$carResponse['licensePlate'] = $car->getLicensePlate();

        	$carData['items'][] = $carResponse;
        }

        $json = json_encode($carData);

		$response = new Response($json);
		$response->headers->set('Content-Type', 'text/json');

        $client->set($cacheEntryIdentifier, base64_encode($json));
        $client->expire($cacheEntryIdentifier, 10);

        return $response;
    }
}
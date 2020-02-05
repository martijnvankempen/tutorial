<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function indexAction()
    {
    	$cars = $this->getDoctrine()
        ->getRepository(Car::class)
        ->findAll();

        $responseData = [];
        $responseData['total'] = count($cars);

        foreach ($cars as $car) {
        	$carResponse = [];
        	$carResponse['numberOfDoors'] = $car->getNumberOfDoors();
        	$carResponse['licensePlate'] = $car->getLicensePlate();

        	$responseData['items'][] = $carResponse;
        }

		$response = new Response(json_encode($responseData));
		$response->headers->set('Content-Type', 'text/json');

        return $response;
    }
}
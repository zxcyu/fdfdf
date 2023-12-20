<?php

namespace App\Controller;

use App\Services\CarServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{

    #[Route('/cars')]
    public function getAllCars(CarServices $carServices)
    {
        $cars = $carServices->getAllCars();
        return new JsonResponse($cars);
    }

    #[Route('/save'), ]
    public function applicationToCar(
        CarServices $carServices,
        Request $request)
    {
        $applicationData = json_decode($request->getContent(), true);
        $result = $carServices->applicationToCar(
            $applicationData['id'],
            $applicationData['date'],
            $applicationData['$initialPayment'],
            $applicationData['$monthlyPayment'],
        );
        return new JsonResponse($result);
    }
    #[Route('/creditcar')]
    public function credictOfCar(CarServices $carServices,Request $request)
    {
        $applicationData = json_decode($request->getContent(), true);
        $result = $carServices->credictOfCar(
            $applicationData['id'],
            $applicationData['date'],
            $applicationData['$initialPayment'],
            $applicationData['$monthlyPayment'],
        );
        return new JsonResponse($result);
    }

}

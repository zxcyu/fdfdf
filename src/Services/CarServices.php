<?php

namespace App\Services;

use App\Model\ApplicationToCarModel;
use App\Model\CarModel;
use App\Model\CreditModel;
use App\Repository\CarRepository;

use DateTime;

use function Symfony\Component\Translation\t;

readonly class CarServices
{
    public function __construct(
        private CarRepository $carRepository,

    ) {
    }

    public function getAllCars(): array
    {
        $cars = $this->carRepository->findAll();
        $allCars = [];
        foreach ($cars as $car){

            $allCars[] = new CarModel(
                $car->getBrend(),
                $car->getModel(),
                $car->getImage(),
                $car->getPrice()
            );

        }

        return $allCars;
    }
    public function credictOfCar(int $id,int $date,int $initialPayment, int $monthlyPayment): CreditModel
    {
        $car =$this->carRepository->findOneBy(['id'=>$id]);
        $carPrice=$car->getPrice();
        $interestRate=12;
        ///не понимаю какая должна быть логика расчёта тут  полная статика с 12%
        if ($initialPayment <= $carPrice/10  && $monthlyPayment <= 20000  && $date <= 5) {
            $totalLoanAmount = $carPrice - $initialPayment;
            $monthlyInterestRate = ($interestRate / 100) / 12;
            $numberOfPayments = $date * 12;
            $monthlyPaymentAmount = ($totalLoanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
        }
        $result = new CreditModel($monthlyPaymentAmount*$numberOfPayments,$monthlyPaymentAmount,$interestRate);
        return $result;
    }
    public function applicationToCar(int $id,int $date,int $initialPayment, int $monthlyPayment) : ApplicationToCarModel
    {
        $car =$this->carRepository->findOneBy(['id'=>$id]);

        $carToCredit = new CarModel(
            $car->getBrend(),
            $car->getModel(),
            $car->getImage(),
            $car->getPrice()
        );
        $credit=$this->credictOfCar($id, $date, $initialPayment,$monthlyPayment);

        return new ApplicationToCarModel($carToCredit,$credit,new DateTime());
    }
}

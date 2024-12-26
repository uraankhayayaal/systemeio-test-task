<?php
 
namespace App\Controller;

use App\Requests\CalculatePriceRequest;
use App\Requests\PurchaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
 
#[Route('/', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods:['post'] )]
    public function price(CalculatePriceRequest $request): JsonResponse
    {
        return $this->json([
            'product' => $request->product,
            'taxNumber' => $request->taxNumber,
            'couponCode' => $request->couponCode,
        ]);
    }
 
 
    #[Route('/purchase', name: 'purchase', methods:['post'] )]
    public function purchase(PurchaseRequest $request): JsonResponse
    {
        return $this->json([
            'product' => $request->product,
            'taxNumber' => $request->taxNumber,
            'couponCode' => $request->couponCode,
            'paymentProcessor' => $request->paymentProcessor,
        ]);
    }
}
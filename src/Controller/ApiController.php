<?php
 
namespace App\Controller;

use App\Payment\PaymentInterface;
use App\Request\CalculatePriceRequest;
use App\Request\PurchaseRequest;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
 
#[Route('/', name: 'api_')]
class ApiController extends AbstractController
{
    public function __construct(
        private OrderService $service,
    ) {}

    #[Route('/calculate-price', name: 'calculate_price', methods:['post'] )]
    public function price(CalculatePriceRequest $request): JsonResponse
    {
        $price = $this->service->calculatePrice($request);

        return $this->json([
            'price' => $price,
        ]);
    }
 
 
    #[Route('/purchase', name: 'purchase', methods:['post'] )]
    public function purchase(PurchaseRequest $request, PaymentInterface $payment): JsonResponse
    {
        $isPaid = $this->service->purchase($request, $payment);

        return $this->json([
            'isPaid' => $isPaid,
        ]);
    }

    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $data = [
            'status' => 'ok',
            'message' => 'success',
            'data' => $data,
        ];

        return parent::json($data, $status, $headers, $context);
    }
}
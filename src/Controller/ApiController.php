<?php
 
namespace App\Controller;

use App\Exception\PaymentException;
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
        try {
            $isPaid = $this->service->purchase($request, $payment);
        } catch (PaymentException $exception) {
            $response = new JsonResponse([
                'message' => 'payment_error',
                'errors' => [
                    [
                        'message' => $exception->getMessage(),
                    ],
                ],
            ]);
            $response->setStatusCode(422)->send();
            exit;
        }

        return $this->json([
            'product' => $request->product,
            'isPaid' => $isPaid,
        ]);
    }
}
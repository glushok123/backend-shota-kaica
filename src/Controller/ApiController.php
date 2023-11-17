<?php

namespace App\Controller;

use App\Dto\TestDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

class ApiController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface             $validatorInterface,
    )
    {
    }

    #[Route('/api/test/get', name: 'app_api_test_get')]
    public function testGet(): Response
    {
        return new JsonResponse(['test' => "value"]);
    }

    #[Route('/api/test/post', name: 'app_api',methods: ['POST'])]
    public function testPost(Request $request, #[MapRequestPayload] TestDto $dto): Response
    {
        return new JsonResponse($dto->toArray());
    }
}

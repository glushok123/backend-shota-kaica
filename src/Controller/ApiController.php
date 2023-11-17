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
    #[Route('/api', name: 'app_api_test_get_1',methods: ['GET'])]
    public function testGet1(): Response
    {
        dd(1);
    }


    #[Route('/api/test/get', name: 'app_api_test_get',methods: ['GET'])]
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

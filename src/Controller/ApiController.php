<?php


namespace App\Controller;

use App\Dto\TestDto;
use App\Service\EkdiService;
use App\Service\TestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");

class ApiController extends AbstractController
{

    public function __construct(
        private readonly EkdiService                    $ekdiService,
    )
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: X-Requested-With");
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

    #[Route('/api/get/ekdi/1', name: 'app_api_get_ekdi_1',methods: ['GET'])]
    public function insertDbEkdi1(): Response
    {
       $data = $this->ekdiService->getEkdi1();

       return new JsonResponse($data);
    }

    #[Route('/api/get/ekdi/2', name: 'app_api_get_ekdi_2',methods: ['GET'])]
    public function insertDbEkdi2(Request $request): Response
    {
        $data = $this->ekdiService->getEkdi2($request->get('ekdi'));
        return new JsonResponse($data);
    }

    #[Route('/api/get/ekdi/3', name: 'app_api_get_ekdi_3',methods: ['GET'])]
    public function insertDbEkdi3(Request $request): Response
    {
        $data = $this->ekdiService->getEkdi3($request->get('ekdi'));
        return new JsonResponse($data);
    }

    #[Route('/api/get/ekdi/4', name: 'app_api_get_ekdi_4',methods: ['GET'])]
    public function insertDbEkdi4(Request $request): Response
    {
        $data = $this->ekdiService->getEkdi4($request->get('ekdi'));
        return new JsonResponse($data);
    }
}

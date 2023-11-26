<?php


namespace App\Controller;

use App\Dto\TestDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\DocumentService;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Denisok94\SymfonyExportXlsxBundle\Service\XlsxService;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");

class ApiController extends AbstractController
{

    public function __construct(
        private readonly TestService                    $testService,
        private readonly EkdiService                    $ekdiService,
        private readonly DocumentService                $documentService,
        private readonly UserPasswordHasherInterface    $passwordHasher,
        private readonly UserRepository                 $userRepository,
        private readonly XlsxService                    $xlsxService,
    )
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: X-Requested-With");
    }

    #[Route('/api', name: 'app_api_test_get_1',methods: ['GET'])]
    public function testGet1()
    {
        $user = new User();
        $user->setEmail('admin@admin.ru');
        $plaintextPassword = '12345678';

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
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

    #[Route('/api/save/case', name: 'app_api_save_case',methods: ['POST'])]
    public function saveCase(Request $request): Response
    {
        $data = $this->documentService->saveCase($request);
        return new JsonResponse($data);
    }

    #[Route('/api/get/case', name: 'app_api_search_case',methods: ['POST'])]
    public function searchCase(Request $request): Response
    {
        $data = $this->documentService->searchCase($request);
        return new JsonResponse($data);
    }

    #[Route('/api/get/generate/exel', name: 'app_api_generate_exel',methods: ['GET'])]
    public function generateExel(Request $request)
    {

        $data = $this->documentService->getCollectionDocuments($request);

        $fileName = 'my_first_excel.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $this->xlsxService->setFile($temp_file)->open();

        foreach ($data as $line) {
            $this->xlsxService->write($line);
        }

        $this->xlsxService->close();

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/api/insert/case', name: 'app_api_insert_case',methods: ['GET'])]
    public function insertCase()
    {
        $this->testService->insertDbCase();
    }
}

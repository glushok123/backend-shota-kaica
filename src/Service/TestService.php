<?php

namespace App\Service;

use App\Entity\Documet;
use App\Entity\Ekdi;
use App\Repository\DocumetRepository;
use App\Repository\EkdiRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class TestService
{
    private $serializer;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly EkdiRepository             $ekdiRepository,
        private readonly DocumetRepository          $documetRepository,

    )
    {
        $metadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new PropertyNormalizer($metadataFactory, null);

        $this->serializer = new Serializer([$normalizer, new DateTimeNormalizer(), new ObjectNormalizer()]);
    }

    public function serialize($entity, $dto, array $ignoredAttribute = [], array $onlyAttribute = [], array $addAttribute = [])
    {
        $conditionOnlyAttribute = empty($onlyAttribute) ? [null] : [AbstractNormalizer::ATTRIBUTES => $onlyAttribute];
        $conditionIgnoredAttribute = empty($ignoredAttribute) ? [null] : [AbstractNormalizer::IGNORED_ATTRIBUTES => $ignoredAttribute];

        $condition = array_merge([
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true
        ], $conditionOnlyAttribute, $conditionIgnoredAttribute);
        $normalize = array_merge($this->serializer->normalize($entity, null, $condition), $addAttribute);

        return $this->serializer->denormalize(
            $normalize, $dto
        );
    }

    public function insertDbEkdi()
    {
        foreach ($this->collectionEkdi as $item) {
            $ekdi = new Ekdi();
            $ekdi->setName($item['Наименование']);
            $ekdi->setCode($item['Код']);
            $this->ekdiRepository->save($ekdi);
        }
    }

    public function insertDbCase()
    {
        ini_set('max_execution_time', 600); //600 seconds
        ini_set('memory_limit','8096M');

        $accessArray = [
            'Р-2278',
            'Р-2433',
            'Р-2467',
            'Р-2592',
            'Р-2592',
            'Р-53',
            'Р-1205',
            'Р-1299',
            'Р-413',
            'Р-871',
            '694',
            '921',
            '927',
            '930',
            '931',
            '936',
            '939',
            '944',
            '945',
            '947',
            '952',
            '953',
            '956',
            '958',
            '960',
        ];

        $caseList694 = [
            "272",
            "273",
            "274",
            "275",
            "276",
            "278",
            "279",
            "280",
            "281",
            "282",
            "283",
            "284",
            "285",
            "286",
            "287",
            "289",
            "290",
            "291",
            "292",
            "293",
            "295",
            "309",
            "310",
            "311",
            "313",
            "314",
            "315",
            "316",
            "317",
            "318",
            "319",
            "320",
            "321",
            "324",
            "325",
            "326",
            "327",
            "328",
            "329",
            "330",
            "331",
            "332",
            "333",
            "334",
            "335",
            "336",
            "430",
            "798",
            "799",
            "873",
            "888",
            "890",
            "1157",
            "1231",
            "1253",
            "1254",
            "1256",
            "1257",
            "1258",
            "1259",
            "1260",
            "1261",
            "1263",
            "1264",
            "1294",
            "1299",
            "1300",
            "1302",
            "1303",
            "1304",
            "1305",
            "1306",
            "1307",
            "1308",
            "1309",
            "1310",
            "1311",
            "1312",
            "1314",
            "1315",
            "1316",
            "1317",
            "1318",
            "1319",
            "1320",
            "1321",
            "1322",
            "1323",
            "1324",
            "1325",
            "1326",
            "1327",
            "1328",
            "1329",
            "1330",
            "1331",
            "1332",
            "1333",
            "1129 А",
            "1173 А",
            "1187 А",
            "1194 А",
            "11 А",
            "11 Б",
            "1205 А",
            "1205 Б",
            "1205 В",
            "1205 Г",
            "1205 Д",
            "1206 А",
            "1206 Б",
            "1206 В",
            "1206 Г",
            "1207 А",
            "1207 Б",
            "1237 А",
            "1240 А",
            "1241 А",
            "1241 Б",
            "1242 А",
            "207 А",
            "596 А",
            "755 А",
            "803 А",
            "81 А",
            "872 А",
            "893 А",
            "999 А",
        ];

        //$fondInfo = include_once($_SERVER['DOCUMENT_ROOT'] . '/data/952.php');
        //$upload1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка - 1.json');
        $upload2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка - 2.json');
        //$upload3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка - 3.json');
        //$upload4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2433_new.json');
        //$upload4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2433_3_new.json');
        //$upload5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2592.json');
        //$upload5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2592_3_new.json');
        //$upload5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2592_1_new.json');

        //$data1 = json_decode($upload4, true);
        $data2 = json_decode($upload2, true);
        //$data3 = json_decode($upload3, true);


        //dd(count($data2));
        $fondInfo = $data2;//array_merge($data1, $data2);

        foreach ($fondInfo as $infoCase) {
            if(empty($infoCase['Номер фонда'])) continue;
            if(empty($infoCase['Номер дела'])) continue;
            if(!in_array($infoCase['Номер фонда'], $accessArray)) continue;
            if(!in_array($infoCase['Номер дела'], $caseList694)) continue;

            if($infoCase['Номер дела'] === 'Номер дела') continue;

            if($infoCase['Номер фонда'] === 'Р-2433'){
                if((int) $infoCase['Номер дела'] > 700){
                    continue;
                }
            }
            if($infoCase['Номер фонда'] !== '694'){
                continue;
            }

            $document = $this->documetRepository->findOneBy([
                'fond' => $infoCase['Номер фонда'],
                'opis' => $infoCase['Номер описи'],
                'numberCase' => $infoCase['Номер дела'],
            ]);

            if (empty($document)){
                $document = new Documet();
            }


            $document->setFond($infoCase['Номер фонда']);
            $document->setOpis($infoCase['Номер описи']);
            $document->setNumberCase($infoCase['Номер дела']);

            $document->setNameCase($infoCase['Дело']);
            $document->setName($infoCase['Заголовок']);
            $document->setAnatation($infoCase['Заголовок']);

            $document->setDeadlineDates($infoCase['Хронологические ']);
            $document->setYearStart($infoCase['Точный год начала']);
            $document->setYearEnd($infoCase['Точный год оконча']);

            $document->setNumberList(isset($infoCase['Количество листов']) ? '1-' . $infoCase['Количество листов'] : '1-');
            $document->setNameFile($infoCase['Номер фонда'] . '_' . $infoCase['Номер описи'] . '_' . preg_replace("/\s+/", "", $infoCase['Номер дела']));

            $this->documetRepository->save($document);
        }
    }
}
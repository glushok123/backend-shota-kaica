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

        //$fondInfo = include_once($_SERVER['DOCUMENT_ROOT'] . '/data/952.php');
        //$upload1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка - 1.json');
        //$upload2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка - 2.json');
        //$upload3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка - 3.json');
        $upload4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2433.json');
        $upload5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/выгрузка Р-2592.json');

        $data1 = json_decode($upload4, true);
        $data2 = json_decode($upload5, true);
        //$data3 = json_decode($upload3, true);

        $fondInfo = array_merge($data1, $data2);

        foreach ($fondInfo as $infoCase) {
            if(empty($infoCase['Номер фонда'])) continue;
            if(empty($infoCase['Номер дела'])) continue;
            if(!in_array($infoCase['Номер фонда'], $accessArray)) continue;

            if($infoCase['Номер дела'] === 'Номер дела') continue;

            if($infoCase['Номер фонда'] === 'Р-2433'){
                if((int) $infoCase['Номер дела'] > 700){
                    continue;
                }
            }

            $document = $this->documetRepository->findOneBy([
                'fond' => $infoCase['Номер фонда'],
                'opis' => $infoCase['Номер описи'],
                'numberCase' => $infoCase['Номер дела'],
            ]);

            if (empty($document)){
                //$document = new Documet();

                continue;
            }

            //$document->setFond($infoCase['Номер фонда']);
            //$document->setOpis($infoCase['Номер описи']);
            //$document->setNumberCase($infoCase['Номер дела']);

            /*if (strlen($infoCase['Дело']) > 25){

            }else{
                $delo = 'Ф.' . $infoCase['Номер фонда'] . ' ' . 'Оп.3' . ' ' . 'Д.' . $infoCase['Номер дела'] . ' ' . $infoCase['Заголовок'];
                $document->setNameCase($delo);
            }*/

            $document->setNameCase($infoCase['Дело']);
            //$document->setName($infoCase['Заголовок']);
            //$document->setAnatation($infoCase['Заголовок']);

            //$document->setDeadlineDates($infoCase['Хронологические ']);
            //$document->setYearStart($infoCase['Точный год начала']);
            //$document->setYearEnd($infoCase['Точный год оконча']);

            //$document->setNumberList(isset($infoCase['Количество листов']) ? '1-' . $infoCase['Количество листов'] : '1-');
            //$document->setNameFile($infoCase['Номер фонда'] . '_' . $infoCase['Номер описи'] . '_' . preg_replace("/\s+/", "", $infoCase['Номер дела']));

            $this->documetRepository->save($document);
        }
    }
}
<?php

namespace App\Service;

use App\Entity\Documet;
use App\Entity\Ekdi;
use App\Repository\DocumetRepository;
use App\Repository\EkdiRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class DocumentService
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

    public function saveCase(Request $request)
    {
        $document = $this->documetRepository->findOneBy([
            'fond' => $request->get('fond'),
            'opis' => $request->get('opis'),
            'numberCase' => $request->get('case'),
        ]);

        if (empty($document)){
            $document = new Documet();
        }

        $document->setFond($request->get('fond'));
        $document->setOpis($request->get('opis'));
        $document->setNumberCase($request->get('case'));
        $document->setNumberList($request->get('listCase'));
        $document->setName($request->get('name'));
        $document->setAnatation($request->get('anatation'));
        $document->setGeography($request->get('geography'));
        $document->setEkdi1($this->ekdiRepository->findOneBy(['id' => $request->get('ekd1')]));
        $document->setEkdi2($this->ekdiRepository->findOneBy(['id' => $request->get('ekd2')]));
        $document->setEkdi3($this->ekdiRepository->findOneBy(['id' => $request->get('ekd3')]));
        $document->setEkdi4($this->ekdiRepository->findOneBy(['id' => $request->get('ekd4')]));
        $document->setNameFile($request->get('nameFile'));
        $document->setUserGroup(empty($request->get('userGroup')) ? 'Отсутствие' : $request->get('userGroup'));
        $document->setDeadlineDates($request->get('deadlineDates'));
        $document->setYearStart($request->get('yearStart'));
        $document->setYearEnd($request->get('yearEnd'));

        $this->documetRepository->save($document);

        return [
            'status' => 'success',
            'message' => 'Успешно сохранено',
        ];
    }

    public function searchCase(Request $request)
    {
        $document = $this->documetRepository->findOneBy([
            'fond' => $request->get('fond'),
            'opis' => $request->get('opis'),
            'numberCase' => $request->get('case'),
        ]);

        if (!empty($document)){
            return [
                'status' => 'success',
                'message' => 'Дело найдено в БД, данные востановлены',
                'data' => [
                    'fond' => $document->getFond(),
                    'opis' => $document->getOpis(),
                    'case' => $document->getNumberCase(),
                    'nameCase' => $document->getNameCase(),
                    'listCase' => $document->getNumberList(),
                    'name' => $document->getName(),
                    'anatation' => $document->getAnatation(),
                    'ekd1' => empty($document->getEkdi1()) ? null : $document->getEkdi1()->getId(),
                    'ekd2' => empty($document->getEkdi2()) ? null :$document->getEkdi2()->getId(),
                    'ekd3' => empty($document->getEkdi3()) ? null :$document->getEkdi3()->getId(),
                    'ekd4' => empty($document->getEkdi4()) ? null :$document->getEkdi4()->getId(),
                    'nameFile' => $document->getNameFile(),
                    'deadlineDates' => $document->getDeadlineDates(),
                    'yearStart' => $document->getYearStart(),
                    'yearEnd' => $document->getYearEnd(),
                ]
            ];
        }

        return [
            'status' => 'warning',
            'message' => 'Дело не найдено',
        ];
    }

    public function getCollectionDocuments(Request $request)
    {
        $count = 1;
        $documentCollect = [];
        if (!empty($request->get('nameFond'))){
            $documents = $this->documetRepository->findBy(['fond' => $request->get('nameFond')]);
        }else{
            $documents = $this->documetRepository->findAll();
        }

        foreach ($documents as $document){
            $edkd1 = empty($document->getEkdi1()) ? '' : $document->getEkdi1()->getName();
            $edkd2 = empty($document->getEkdi2()) ? '' : $document->getEkdi2()->getName();
            $edkd3 = empty($document->getEkdi3()) ? '' : $document->getEkdi3()->getName();
            $edkd4 = empty($document->getEkdi4()) ? '' : $document->getEkdi4()->getName();
            $documentCollect[] = [
                '№' => $count,
                'Дело' => $document->getNameCase(),
                'Листы дела' => $document->getNumberList(),
                'Наименование' => $document->getName(),
                'Аннотация' => $document->getAnatation(),
                'География.Населенный пункт, улица' => $document->getGeography(),
                'Крайние даты' => $document->getDeadlineDates(),
                'Точный год начала' => $document->getYearStart(),
                'Точный год окончания' => $document->getYearEnd(),
                'Классификация по ЕКДИ.Классификация по ЕКДИ' =>
                    $edkd1 . '\\' .
                    $edkd2 . '\\' .
                    $edkd3 . '\\' .
                    $edkd4,
                'Показывать на сайте?' => 'да',
                'Документ отсканирован полностью?' => 'да',
                'Файл' => $document->getNameFile(),
            ];

            $count += 1;
        }

        return $documentCollect;
    }
}

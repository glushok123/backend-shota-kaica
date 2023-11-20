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
        private readonly DocumetRepository          $documetRepository
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
            'opis' => $request->get('fond'),
            'case' => $request->get('case'),
        ]);

        if (empty($document)){
            $document = new Documet();
        }

        $document->setFond($request->get('fond'));
        $document->setOpis($request->get('opis'));
        $document->setNumberCase($request->get('case'));
        $document->setNumberList($request->get('listCase'));
        $document->setName($request->get('name'));
        $document->setAnatation($request->get('fond'));
        $document->setEkdi1($request->get('ekd1'));
        $document->setEkdi2($request->get('ekd2'));
        $document->setEkdi3($request->get('ekd3'));
        $document->setEkdi4($request->get('ekd4'));
        $document->setNameFile($request->get('nameFile'));

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
            'opis' => $request->get('fond'),
            'case' => $request->get('case'),
        ]);

        if (!empty($document)){
            $document = new Documet();
            return [
                'status' => 'warning',
                'message' => 'Дело найдено в БД, данные востановлены',
                'data' => [
                    'fond' => $document->getFond(),
                    'opis' => $document->getOpis(),
                    'case' => $document->getNumberCase(),
                    'listCase' => $document->getNumberList(),
                    'name' => $document->getName(),
                    'anatation' => $document->getAnatation(),
                    'ekd1' => $document->getEkdi1()->getId(),
                    'ekd2' => $document->getEkdi2()->getId(),
                    'ekd3' => $document->getEkdi3()->getId(),
                    'ekd4' => $document->getEkdi4()->getId(),
                    'nameFile' => $document->getNameFile(),
                ]
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Дело не найдено',
        ];
    }
}
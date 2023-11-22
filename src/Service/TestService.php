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
        $fondInfo = include_once($_SERVER['DOCUMENT_ROOT'] . '/data/952.php');

        foreach ($fondInfo as $infoCase) {
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

            $document->setDeadlineDates($infoCase['Хронологические ']);
            $document->setYearStart($infoCase['Точный год начала']);
            $document->setYearEnd($infoCase['Точный год оконча']);

            $document->setNumberList($infoCase['Количество листов']);
            $document->setNameFile($infoCase['Номер фонда'] . '_' . $infoCase['Номер описи'] . '_' . $infoCase['Номер дела']);

            $this->documetRepository->save($document);
        }
    }
}

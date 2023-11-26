<?php

namespace App\Service;

use App\Entity\Ekdi;
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

class EkdiService
{
    private $serializer;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EkdiRepository $ekdiRepository

    )
    {
        $metadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new PropertyNormalizer($metadataFactory, null);

        $this->serializer = new Serializer([$normalizer, new DateTimeNormalizer(), new ObjectNormalizer()]);
    }

    public function serialize($entity, array $ignoredAttribute = [], array $onlyAttribute = [], array $addAttribute = [])
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

        return $normalize;
    }

    public function getEkdi1(){
        $collectionEkdi = [];
        $ekdis = $this->ekdiRepository->getCollectionEkdi1();

        foreach ($ekdis as $ekdi){
            $collectionEkdi[] = $this->serialize($ekdi);
        }

        return $collectionEkdi;
    }

    public function getEkdi2(string $ekdi1){
        $collectionEkdi = [];
        $value = substr($ekdi1, 0, 2);
        $ekdis = $this->ekdiRepository->getCollectionEkdi2($value);

        foreach ($ekdis as $ekdi){
            if ($ekdi->getCode() == $ekdi1) continue;
            $collectionEkdi[] = $this->serialize($ekdi);
        }

        return $collectionEkdi;
    }

    public function getEkdi3(string $ekdi2){
        $collectionEkdi = [];
        $value = substr($ekdi2, 0, 5);
        $ekdis = $this->ekdiRepository->getCollectionEkdi3($value);

        foreach ($ekdis as $ekdi){
            if ($ekdi->getCode() == $ekdi2) continue;
            $collectionEkdi[] = $this->serialize($ekdi);
        }

        return $collectionEkdi;
    }

    public function getEkdi4(string $ekdi3){
        $collectionEkdi = [];
        $value = substr($ekdi3, 0, 8);
        $ekdis = $this->ekdiRepository->getCollectionEkdi4($value);

        foreach ($ekdis as $ekdi){
            if ($ekdi->getCode() == $ekdi3) continue;
            $collectionEkdi[] = $this->serialize($ekdi);
        }

        return $collectionEkdi;
    }
}
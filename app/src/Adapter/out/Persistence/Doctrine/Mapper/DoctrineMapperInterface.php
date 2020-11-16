<?php

namespace App\Adapter\out\Persistence\Doctrine\Mapper;

use Exception;


interface DoctrineMapperInterface
{
    public function normalize($data, string $format = null, array $context = []);

    /**
     * @param $entity
     * @param $type
     *
     * @return mixed
     * @throws Exception
     */
    public function denormalize($entity,$type);

}
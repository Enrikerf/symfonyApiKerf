<?php

namespace App\Adapter\out\Persistence\Doctrine\Mapper;

interface DoctrineMapperInterface
{
    public function normalize($data, string $format = null, array $context = []);

    /**
     * @param $entity mixed DoctrineEntity or DomainEntity
     * @param $type mixed  DoctrineEntity or DomainEntity
     *
     * @return mixed DoctrineEntity or DomainEntity
     */
    public function denormalize($entity,$type);

}
<?php

namespace App\Application\Model;

class ResponseCode
{

    const OK = '200';
    const NOT_FOUND = '404';
    const BAD_REQUEST = '400';
    const OBJECT_CREATED = '201';
    const PERSISTENCE_EXCEPTION = '500';
    const DOMAIN_EXCEPTION = '500';
}
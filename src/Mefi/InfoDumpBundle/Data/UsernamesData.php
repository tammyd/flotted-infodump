<?php

namespace Mefi\InfoDumpBundle\Data;

use Doctrine\ORM\EntityManager;

class UsernamesData extends SingleTableInfodumpData
{

    const DOCTRINE_CLASS = 'MefiInfoDumpBundle:Usernames';
    const DATE_FIELD = 'joindate';

    public function __construct(EntityManager $em, $useCache=true, $cacheTime=3600)
    {
        parent::__construct($em, self::DOCTRINE_CLASS, $useCache, $cacheTime);
    }
}

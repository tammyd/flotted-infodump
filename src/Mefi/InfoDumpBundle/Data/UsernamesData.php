<?php

namespace Mefi\InfoDumpBundle\Data;

use Doctrine\ORM\EntityManager;

class UsernamesData extends SingleTableData
{

    const DOCTRINE_CLASS = 'MefiInfoDumpBundle:Usernames';
    const DATE_FIELD = 'joindate';

    public function __construct(EntityManager $em, $useCache=true, $cacheTime=3600)
    {
        $this->setEntityManager($em);
        $this->setClassName(self::DOCTRINE_CLASS);
        $this->setUseCache($useCache);
        $this->setCacheTime($cacheTime);
    }
}

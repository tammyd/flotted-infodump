<?php

namespace Mefi\InfoDumpBundle\Data;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

abstract class InfodumpData
{
    protected $entityManager;
    protected $cacheTime;
    protected $useCache;

    public function __construct(EntityManager $em, $useCache=true, $cacheTime=3600)
    {
        $this->entityManager = $em;
        $this->setUseCache($useCache);
        $this->setCacheTime($cacheTime);
    }

    public function setCacheTime($cacheTime)
    {
        $this->cacheTime = intval($cacheTime);
    }

    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    public function setUseCache($useCache)
    {
        $this->useCache = $useCache ? true : false;
    }

    public function getUseCache()
    {
        return $this->useCache;
    }

    protected function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function buildCacheKey($function, $args) {
        return $this->getCachePrefix().":".$function.":".md5(json_encode($args));
    }

    protected function buildSingleTypeRSM($fields, $type) {
        $rsm = new ResultSetMapping();
        array_map(function($f) use ($rsm, $type) {$rsm->addScalarResult($f, $f, $type);}, $fields);
        return $rsm;

    }

    abstract protected function getCachePrefix();

}

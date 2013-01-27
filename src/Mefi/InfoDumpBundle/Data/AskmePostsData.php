<?php

namespace Mefi\InfoDumpBundle\Data;

use Doctrine\ORM\EntityManager;

class AskmePostsData extends SingleTableData
{

    const DOCTRINE_CLASS = 'MefiInfoDumpBundle:PostdataAskme';
    const DATE_FIELD = 'datestamp';

    public function __construct(EntityManager $em, $useCache=true, $cacheTime=3600)
    {
        $this->setEntityManager($em);
        $this->setClassName(self::DOCTRINE_CLASS);
        $this->setUseCache($useCache);
        $this->setCacheTime($cacheTime);
    }

    public function getPercentDeletedByDate() {

    }
}


/*create temporary table deleted as select count(*) as deleted_count, date(datestamp) as date from postdata_askme where deleted =1 group by date;
create temporary table posts as select count(*) as count, date(datestamp) as date from postdata_askme group by date;


select posts.date, posts.count, deleted.deleted_count,
deleted.deleted_count / posts.count as percentage_deleted from posts, deleted where posts.date=deleted.date order by posts.date asc;
*/
<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use  Doctrine\ORM\Query\ResultSetMapping;
use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;

class CommentdataAskmeRepository extends InfodumpRepository
{

    public function getCountCommentsByDate()
    {
        return $this->getByDate('datestamp');

    }

}
<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use  Doctrine\ORM\Query\ResultSetMapping;
use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;

class CommentdataAskmeRepository extends InfodumpRepository
{

    public function findCountCommentsByDate()
    {
        return $this->getByDate('datestamp');

    }

}
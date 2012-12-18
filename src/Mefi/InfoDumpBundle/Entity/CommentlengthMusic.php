<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\CommentlengthMusic
 *
 * @ORM\Table(name="commentlength_music")
 * @ORM\Entity
 */
class CommentlengthMusic
{
    /**
     * @var integer $commentid
     *
     * @ORM\Column(name="commentid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentid;

    /**
     * @var integer $length
     *
     * @ORM\Column(name="length", type="integer", nullable=true)
     */
    private $length;



    /**
     * Get commentid
     *
     * @return integer 
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     * Set length
     *
     * @param integer $length
     * @return CommentlengthMusic
     */
    public function setLength($length)
    {
        $this->length = $length;
    
        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getLength()
    {
        return $this->length;
    }
}
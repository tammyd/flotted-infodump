<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\CommentdataAskme
 *
 * @ORM\Table(name="commentdata_askme")
 * @ORM\Entity(repositoryClass="Mefi\InfoDumpBundle\Entity\Repository\CommentdataAskmeRepository")
 */
class CommentdataAskme
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
     * @var integer $postid
     *
     * @ORM\Column(name="postid", type="integer", nullable=true)
     */
    private $postid;

    /**
     * @var integer $userid
     *
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $userid;

    /**
     * @var \DateTime $datestamp
     *
     * @ORM\Column(name="datestamp", type="datetime", nullable=true)
     */
    private $datestamp;

    /**
     * @var integer $faves
     *
     * @ORM\Column(name="faves", type="integer", nullable=true)
     */
    private $faves;

    /**
     * @var boolean $bestanswer
     *
     * @ORM\Column(name="bestanswer", type="boolean", nullable=true)
     */
    private $bestanswer;



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
     * Set postid
     *
     * @param integer $postid
     * @return CommentdataAskme
     */
    public function setPostid($postid)
    {
        $this->postid = $postid;
    
        return $this;
    }

    /**
     * Get postid
     *
     * @return integer 
     */
    public function getPostid()
    {
        return $this->postid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return CommentdataAskme
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set datestamp
     *
     * @param \DateTime $datestamp
     * @return CommentdataAskme
     */
    public function setDatestamp($datestamp)
    {
        $this->datestamp = $datestamp;
    
        return $this;
    }

    /**
     * Get datestamp
     *
     * @return \DateTime 
     */
    public function getDatestamp()
    {
        return $this->datestamp;
    }

    /**
     * Set faves
     *
     * @param integer $faves
     * @return CommentdataAskme
     */
    public function setFaves($faves)
    {
        $this->faves = $faves;
    
        return $this;
    }

    /**
     * Get faves
     *
     * @return integer 
     */
    public function getFaves()
    {
        return $this->faves;
    }

    /**
     * Set bestanswer
     *
     * @param boolean $bestanswer
     * @return CommentdataAskme
     */
    public function setBestanswer($bestanswer)
    {
        $this->bestanswer = $bestanswer;
    
        return $this;
    }

    /**
     * Get bestanswer
     *
     * @return boolean 
     */
    public function getBestanswer()
    {
        return $this->bestanswer;
    }
}
<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\PostdataMeta
 *
 * @ORM\Table(name="postdata_meta")
 * @ORM\Entity
 */
class PostdataMeta
{
    /**
     * @var integer $postid
     *
     * @ORM\Column(name="postid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @var integer $category
     *
     * @ORM\Column(name="category", type="integer", nullable=true)
     */
    private $category;

    /**
     * @var integer $comments
     *
     * @ORM\Column(name="comments", type="integer", nullable=true)
     */
    private $comments;

    /**
     * @var integer $favorites
     *
     * @ORM\Column(name="favorites", type="integer", nullable=true)
     */
    private $favorites;

    /**
     * @var boolean $deleted
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @var string $reason
     *
     * @ORM\Column(name="reason", type="text", nullable=true)
     */
    private $reason;



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
     * @return PostdataMeta
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
     * @return PostdataMeta
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
     * Set category
     *
     * @param integer $category
     * @return PostdataMeta
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return integer 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set comments
     *
     * @param integer $comments
     * @return PostdataMeta
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    
        return $this;
    }

    /**
     * Get comments
     *
     * @return integer 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set favorites
     *
     * @param integer $favorites
     * @return PostdataMeta
     */
    public function setFavorites($favorites)
    {
        $this->favorites = $favorites;
    
        return $this;
    }

    /**
     * Get favorites
     *
     * @return integer 
     */
    public function getFavorites()
    {
        return $this->favorites;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return PostdataMeta
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return PostdataMeta
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }
}
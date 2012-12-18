<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\Favoritesdata
 *
 * @ORM\Table(name="favoritesdata")
 * @ORM\Entity
 */
class Favoritesdata
{
    /**
     * @var integer $favoritesdataId
     *
     * @ORM\Column(name="favoritesdata_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $favoritesdataId;

    /**
     * @var integer $faveid
     *
     * @ORM\Column(name="faveid", type="integer", nullable=true)
     */
    private $faveid;

    /**
     * @var integer $faver
     *
     * @ORM\Column(name="faver", type="integer", nullable=true)
     */
    private $faver;

    /**
     * @var integer $favee
     *
     * @ORM\Column(name="favee", type="integer", nullable=true)
     */
    private $favee;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var integer $target
     *
     * @ORM\Column(name="target", type="integer", nullable=true)
     */
    private $target;

    /**
     * @var integer $parent
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    private $parent;

    /**
     * @var \DateTime $datestamp
     *
     * @ORM\Column(name="datestamp", type="datetime", nullable=true)
     */
    private $datestamp;



    /**
     * Get favoritesdataId
     *
     * @return integer 
     */
    public function getFavoritesdataId()
    {
        return $this->favoritesdataId;
    }

    /**
     * Set faveid
     *
     * @param integer $faveid
     * @return Favoritesdata
     */
    public function setFaveid($faveid)
    {
        $this->faveid = $faveid;
    
        return $this;
    }

    /**
     * Get faveid
     *
     * @return integer 
     */
    public function getFaveid()
    {
        return $this->faveid;
    }

    /**
     * Set faver
     *
     * @param integer $faver
     * @return Favoritesdata
     */
    public function setFaver($faver)
    {
        $this->faver = $faver;
    
        return $this;
    }

    /**
     * Get faver
     *
     * @return integer 
     */
    public function getFaver()
    {
        return $this->faver;
    }

    /**
     * Set favee
     *
     * @param integer $favee
     * @return Favoritesdata
     */
    public function setFavee($favee)
    {
        $this->favee = $favee;
    
        return $this;
    }

    /**
     * Get favee
     *
     * @return integer 
     */
    public function getFavee()
    {
        return $this->favee;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Favoritesdata
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set target
     *
     * @param integer $target
     * @return Favoritesdata
     */
    public function setTarget($target)
    {
        $this->target = $target;
    
        return $this;
    }

    /**
     * Get target
     *
     * @return integer 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     * @return Favoritesdata
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set datestamp
     *
     * @param \DateTime $datestamp
     * @return Favoritesdata
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
}
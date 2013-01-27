<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TagdataMeta
 *
 * @ORM\Table(name="tagdata_meta")
 * @ORM\Entity
 */
class TagdataMeta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tagid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tagid;

    /**
     * @var integer
     *
     * @ORM\Column(name="linkid", type="integer", nullable=true)
     */
    private $linkid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="linkdate", type="datetime", nullable=true)
     */
    private $linkdate;

    /**
     * @var string
     *
     * @ORM\Column(name="tagname", type="text", nullable=true)
     */
    private $tagname;



    /**
     * Get tagid
     *
     * @return integer 
     */
    public function getTagid()
    {
        return $this->tagid;
    }

    /**
     * Set linkid
     *
     * @param integer $linkid
     * @return TagdataMeta
     */
    public function setLinkid($linkid)
    {
        $this->linkid = $linkid;
    
        return $this;
    }

    /**
     * Get linkid
     *
     * @return integer 
     */
    public function getLinkid()
    {
        return $this->linkid;
    }

    /**
     * Set linkdate
     *
     * @param \DateTime $linkdate
     * @return TagdataMeta
     */
    public function setLinkdate($linkdate)
    {
        $this->linkdate = $linkdate;
    
        return $this;
    }

    /**
     * Get linkdate
     *
     * @return \DateTime 
     */
    public function getLinkdate()
    {
        return $this->linkdate;
    }

    /**
     * Set tagname
     *
     * @param string $tagname
     * @return TagdataMeta
     */
    public function setTagname($tagname)
    {
        $this->tagname = $tagname;
    
        return $this;
    }

    /**
     * Get tagname
     *
     * @return string 
     */
    public function getTagname()
    {
        return $this->tagname;
    }
}
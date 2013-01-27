<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostlengthMusic
 *
 * @ORM\Table(name="postlength_music")
 * @ORM\Entity
 */
class PostlengthMusic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="postid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postid;

    /**
     * @var integer
     *
     * @ORM\Column(name="title", type="integer", nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="above", type="integer", nullable=false)
     */
    private $above;

    /**
     * @var integer
     *
     * @ORM\Column(name="below", type="integer", nullable=false)
     */
    private $below;

    /**
     * @var integer
     *
     * @ORM\Column(name="url", type="integer", nullable=false)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="urldesc", type="integer", nullable=false)
     */
    private $urldesc;



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
     * Set title
     *
     * @param integer $title
     * @return PostlengthMusic
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return integer 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set above
     *
     * @param integer $above
     * @return PostlengthMusic
     */
    public function setAbove($above)
    {
        $this->above = $above;
    
        return $this;
    }

    /**
     * Get above
     *
     * @return integer 
     */
    public function getAbove()
    {
        return $this->above;
    }

    /**
     * Set below
     *
     * @param integer $below
     * @return PostlengthMusic
     */
    public function setBelow($below)
    {
        $this->below = $below;
    
        return $this;
    }

    /**
     * Get below
     *
     * @return integer 
     */
    public function getBelow()
    {
        return $this->below;
    }

    /**
     * Set url
     *
     * @param integer $url
     * @return PostlengthMusic
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return integer 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set urldesc
     *
     * @param integer $urldesc
     * @return PostlengthMusic
     */
    public function setUrldesc($urldesc)
    {
        $this->urldesc = $urldesc;
    
        return $this;
    }

    /**
     * Get urldesc
     *
     * @return integer 
     */
    public function getUrldesc()
    {
        return $this->urldesc;
    }
}
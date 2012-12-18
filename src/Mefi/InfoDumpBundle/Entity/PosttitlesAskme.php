<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\PosttitlesAskme
 *
 * @ORM\Table(name="posttitles_askme")
 * @ORM\Entity
 */
class PosttitlesAskme
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="text", nullable=true)
     */
    private $title;



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
     * @param string $title
     * @return PosttitlesAskme
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
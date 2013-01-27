<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryMusic
 *
 * @ORM\Table(name="category_music")
 * @ORM\Entity
 */
class CategoryMusic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="categoryid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryid;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url_stub", type="string", length=50, nullable=false)
     */
    private $urlStub;



    /**
     * Get categoryid
     *
     * @return integer 
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CategoryMusic
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set urlStub
     *
     * @param string $urlStub
     * @return CategoryMusic
     */
    public function setUrlStub($urlStub)
    {
        $this->urlStub = $urlStub;
    
        return $this;
    }

    /**
     * Get urlStub
     *
     * @return string 
     */
    public function getUrlStub()
    {
        return $this->urlStub;
    }
}
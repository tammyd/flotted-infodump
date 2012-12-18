<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\Favoritestypes
 *
 * @ORM\Table(name="favoritestypes")
 * @ORM\Entity
 */
class Favoritestypes
{
    /**
     * @var integer $siteid
     *
     * @ORM\Column(name="siteid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $siteid;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;



    /**
     * Get siteid
     *
     * @return integer 
     */
    public function getSiteid()
    {
        return $this->siteid;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Favoritestypes
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
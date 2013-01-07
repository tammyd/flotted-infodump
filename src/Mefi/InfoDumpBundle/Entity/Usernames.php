<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\Usernames
 *
 * @ORM\Table(name="usernames")
 */
class Usernames
{
    /**
     * @var integer $userid
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userid;

    /**
     * @var \DateTime $joindate
     *
     * @ORM\Column(name="joindate", type="datetime", nullable=true)
     */
    private $joindate;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;



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
     * Set joindate
     *
     * @param \DateTime $joindate
     * @return Usernames
     */
    public function setJoindate($joindate)
    {
        $this->joindate = $joindate;
    
        return $this;
    }

    /**
     * Get joindate
     *
     * @return \DateTime 
     */
    public function getJoindate()
    {
        return $this->joindate;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Usernames
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
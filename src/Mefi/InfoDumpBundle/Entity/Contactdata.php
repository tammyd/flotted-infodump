<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mefi\InfoDumpBundle\Entity\Contactdata
 *
 * @ORM\Table(name="contactdata")
 * @ORM\Entity
 */
class Contactdata
{
    /**
     * @var integer $contactId
     *
     * @ORM\Column(name="contact_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $contactId;

    /**
     * @var integer $contacter
     *
     * @ORM\Column(name="contacter", type="integer", nullable=true)
     */
    private $contacter;

    /**
     * @var integer $contactee
     *
     * @ORM\Column(name="contactee", type="integer", nullable=true)
     */
    private $contactee;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;



    /**
     * Get contactId
     *
     * @return integer 
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set contacter
     *
     * @param integer $contacter
     * @return Contactdata
     */
    public function setContacter($contacter)
    {
        $this->contacter = $contacter;
    
        return $this;
    }

    /**
     * Get contacter
     *
     * @return integer 
     */
    public function getContacter()
    {
        return $this->contacter;
    }

    /**
     * Set contactee
     *
     * @param integer $contactee
     * @return Contactdata
     */
    public function setContactee($contactee)
    {
        $this->contactee = $contactee;
    
        return $this;
    }

    /**
     * Get contactee
     *
     * @return integer 
     */
    public function getContactee()
    {
        return $this->contactee;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Contactdata
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
<?php

namespace Workshop_5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="Workshop_5Bundle\Repository\PhoneRepository")
 */
class Phone {
    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="emails")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $person;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(min=9,
     * minMessage = "Nr telefonu musi składać się z minimum 9 znaków."
     * )
     * @ORM\Column(name="phoneNumber", type="integer")
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     * @return Phone
     */
    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return integer 
     */
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Phone
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * Set person
     *
     * @param \Workshop_5Bundle\Entity\Person $person
     * @return Phone
     */
    public function setPerson(\Workshop_5Bundle\Entity\Person $person = null) {
        $this->person = $person;
        return $this;
    }
    
    
    /**
     * Get person
     *
     * @return \Workshop_5Bundle\Entity\Person 
     */
    public function getPerson() {
        return $this->person;
    }
    
     public function __toString() {
        return $this->type;
    }

}
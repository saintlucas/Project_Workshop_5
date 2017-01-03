<?php

namespace Workshop_5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="Workshop_5Bundle\Repository\EmailRepository")
 */
class Email {
    
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
     * @Assert\Length(min=10,
     * minMessage = "Adres email to minimum 10 znaków."
     * )
     * @ORM\Column(name="emailAddress", type="string", length=255)
     */
    private $emailAddress;

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
     * Set emailAddress
     *
     * @param string $emailAddress
     * @return Email
     */
    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string 
     */
    public function getEmailAddress() {
        return $this->emailAddress;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Email
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
     * @return Email
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

}
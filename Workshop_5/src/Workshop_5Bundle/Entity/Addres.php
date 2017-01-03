<?php

namespace Workshop_5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Addres
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Workshop_5Bundle\Repository\AddresRepository")
 */
class Addres {
    
    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="addresses")
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
     * @Assert\Length(min=5,
     * minMessage = "Nazwa miasta to minimum 5 znaków."
     * )
     * @ORM\Column(name="city", type="string", length=100)
     */
    private $city;

    /**
     * @var string
     * @Assert\Length(min=5,
     * minMessage = "Nazwa ulicy to minimum 5 znaków."
     * )
     * @ORM\Column(name="street", type="string", length=100)
     */
    private $street;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="house_number", type="integer")
     */
    private $houseNumber;

    /**
     * @var int
     *@ Assert\NotBlank()
     * @ORM\Column(name="appartment_number", type="integer")
     */
    private $appartmentNumber;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Addres
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Addres
     */
    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     * @return Addres
     */
    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return integer 
     */
    public function getHouseNumber() {
        return $this->houseNumber;
    }

    /**
     * Set appartmentNumber
     *
     * @param integer $appartmentNumber
     * @return Addres
     */
    public function setAppartmentNumber($appartmentNumber) {
        $this->appartmentNumber = $appartmentNumber;

        return $this;
    }

    /**
     * Get appartmentNumber
     *
     * @return integer 
     */
    public function getAppartmentNumber() {
        return $this->appartmentNumber;
    }
    
    
    /**
     * Set person
     *
     * @param \Workshop_5Bundle\Entity\Person $person
     * @return Addres
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
<?php

namespace Workshop_5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="Workshop_5Bundle\Repository\PersonRepository")
 */
class Person {
    
    /**
     * @ORM\ManyToMany(targetEntity="UsersGroup", inversedBy="persons")
     * @ORM\JoinTable(name="users_group_person")
     */
    private $groups;
    
    /**
     * @ORM\OneToMany(targetEntity="Addres", mappedBy="person", cascade={"remove"})
     */
    private $addresses;
    
    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person", cascade={"remove"})
     */
    private $phones;
    
    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="person", cascade={"remove"})
     */
    private $emails;

    
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
     * minMessage = "Imię musi składać się z minimum 5 znaków."
     *)
     * @ORM\Column(name="Name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(min=5,
     * minMessage = "Nazwisko powinno składać się z minimum 5 znaków."
     * )
     * @ORM\Column(name="Surname", type="string", length=100)
     */
    private $surname;

    /**
     * @var string
     * @Assert\Length(min=8,
     * minMessage = "Opis powinien składać się z minimum 8 znaków."
     * )
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    /**
     * Get id
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Person
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Person
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Person
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }
    
    
    /**
     * Constructor
     */
    public function __construct() {
        
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * Add addresses
     *
     * @param \Workshop_5Bundle\Entity\Addres $addresses
     * @return Person
     */
    public function addAddresses(\Workshop_5Bundle\Entity\Addres $addresses) {
        $this->addresses[] = $addresses;
        return $this;
    }
    
    /**
     * Remove addresses
     *
     * @param \Workshop_5Bundle\Entity\Addres $addresses
     */
    public function removeAddresses(\Workshop_5Bundle\Entity\Addres $addresses) {
        $this->addresses->removeElement($addresses);
    }
    
    
    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses() {
        return $this->addresses;
    }
    
    /**
     * Add phones
     *
     * @param \Workshop_5Bundle\Entity\Phone $phones
     * @return Person
     */
    public function addPhone(\Workshop_5Bundle\Entity\Phone $phones) {
        $this->phones[] = $phones;
        return $this;
    }
    
    
    /**
     * Remove phones
     *
     * @param \Workshop_5Bundle\Entity\Phone $phones
     */
    public function removePhones(\Workshop_5Bundle\Entity\Phone $phones) {
        $this->phones->removeElement($phones);
    }
    
    
    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones() {
        return $this->phones;
    }
    
    /**
     * Add emails
     *
     * @param \Workshop_5Bundle\Entity\Email $emails
     * @return Person
     */
    public function addEmails(\Workshop_5Bundle\Entity\Email $emails) {
        $this->emails[] = $emails;
        return $this;
    }
    
    /**
     * Remove emails
     *
     * @param \Workshop_5Bundle\Entity\Email $emails
     */
    public function removeEmails(\Workshop_5Bundle\Entity\Email $emails) {
        $this->emails->removeElement($emails);
    }
    
    
    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails() {
        return $this->emails;
    }
    
    
    /**
     * Add users
     *
     * @param \Workshop_5Bundle\Entity\User $users
     * @return Person
     */
    public function addUser(\Workshop_5Bundle\Entity\User $users) {
        $this->users[] = $users;
        return $this;
    }
    
    
    /**
     * Remove users
     *
     * @param \Workshop_5Bundle\Entity\User $users
     */
    public function removeUsers(\Workshop_5Bundle\Entity\User $users) {
        $this->users->removeElement($users);
    }
    
    
    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers() {
        return $this->users;
    }
    
    public function __toString() {
        return $this->name;
    }
    
    
    /**
     * Add groups
     *
     * @param \Workshop_5Bundle\Entity\Groups $groups
     * @return Person
     */
    public function addGroups(\Workshop_5Bundle\Entity\Groups $groups) {
        $this->groups[] = $groups;
        return $this;   
    }
    
    /**
     * Remove groups
     *
     * @param \Workshop_5Bundle\Entity\Groups $groups
     */
    public function removeGroups(\Workshop_5Bundle\Entity\Groups $groups) {
        $this->groups->removeElement($groups);
    }
    
    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups() {
        return $this->groups;
    }
    
//sortowanie alfabetycznie
    static function cmp_obj($a, $b) {
        
        $al = strtolower($a->name);
        $bl = strtolower($b->name);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }

}
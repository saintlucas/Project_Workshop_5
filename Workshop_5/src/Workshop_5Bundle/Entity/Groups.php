<?php

namespace Workshop_5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="Workshop_5Bundle\Repository\GroupsRepository")
 */
class Groups {

    /**
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="groups")
     */
    private $persons;

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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Groups
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
     * Constructor
     */
    public function __construct() {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groups
     *
     * @param \Workshop_5Bundle\Entity\Groups $groups
     * @return UsersGroup
     */
    public function addGroup(\Workshop_5Bundle\Entity\Groups $groups) {
        $this->groups[] = $groups;
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Workshop_5Bundle\Entity\Groups $groups
     */
    public function removeGroup(\Workshop_5Bundle\Entity\Groups $groups) {
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

    public function __toString() {
        return $this->name;
    }

    /**
     * Add persons
     *
     * @param \Workshop_5Bundle\Entity\Person $persons
     * @return UsersGroup
     */
    public function addPerson(\Workshop_5Bundle\Entity\Person $persons) {
        $this->persons[] = $persons;
        return $this;
    }

    /**
     * Remove persons
     *
     * @param \Workshop_5Bundle\Entity\Person $persons
     */
    public function removePerson(\Workshop_5Bundle\Entity\Person $persons) {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons() {
        return $this->persons;
    }

}
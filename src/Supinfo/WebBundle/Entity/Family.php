<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\Family
 */
class Family
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var Supinfo\WebBundle\Entity\SubFamily
     */
    private $subFamilies;

    public function __construct()
    {
        $this->subFamilies = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add subFamilies
     *
     * @param Supinfo\WebBundle\Entity\SubFamily $subFamilies
     */
    public function addSubFamilies(\Supinfo\WebBundle\Entity\SubFamily $subFamilies)
    {
        $this->subFamilies[] = $subFamilies;
    }

    /**
     * Get subFamilies
     *
     * @return Doctrine\Common\Collections\Collection $subFamilies
     */
    public function getSubFamilies()
    {
        return $this->subFamilies;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
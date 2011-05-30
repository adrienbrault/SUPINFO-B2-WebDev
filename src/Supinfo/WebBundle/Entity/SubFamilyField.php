<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\SubFamilyField
 */
class SubFamilyField
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
    private $subFamily;


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
     * Set subFamily
     *
     * @param Supinfo\WebBundle\Entity\SubFamily $subFamily
     */
    public function setSubFamily(\Supinfo\WebBundle\Entity\SubFamily $subFamily)
    {
        $this->subFamily = $subFamily;
    }

    /**
     * Get subFamily
     *
     * @return Supinfo\WebBundle\Entity\SubFamily $subFamily
     */
    public function getSubFamily()
    {
        return $this->subFamily;
    }
}
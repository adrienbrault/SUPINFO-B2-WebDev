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

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * @var Supinfo\WebBundle\Entity\SubFamilyFieldValue
     */
    private $fieldValues;

    public function __construct()
    {
        $this->fieldValues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add fieldValues
     *
     * @param Supinfo\WebBundle\Entity\SubFamilyFieldValue $fieldValues
     */
    public function addFieldValues(\Supinfo\WebBundle\Entity\SubFamilyFieldValue $fieldValues)
    {
        $this->fieldValues[] = $fieldValues;
    }

    /**
     * Get fieldValues
     *
     * @return Doctrine\Common\Collections\Collection $fieldValues
     */
    public function getFieldValues()
    {
        return $this->fieldValues;
    }
}
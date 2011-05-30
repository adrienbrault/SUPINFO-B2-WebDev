<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\Article
 */
class Article
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $code
     */
    private $code;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var integer $state
     */
    private $state;

    /**
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @var Supinfo\WebBundle\Entity\SubFamilyFieldValue
     */
    private $fieldValues;

    /**
     * @var Supinfo\WebBundle\Entity\Place
     */
    private $place;

    /**
     * @var Supinfo\WebBundle\Entity\SubFamily
     */
    private $subFamily;

    public function __construct()
    {
        $this->fieldValues = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set state
     *
     * @param integer $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return integer $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
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

    /**
     * Set place
     *
     * @param Supinfo\WebBundle\Entity\Place $place
     */
    public function setPlace(\Supinfo\WebBundle\Entity\Place $place)
    {
        $this->place = $place;
    }

    /**
     * Get place
     *
     * @return Supinfo\WebBundle\Entity\Place $place
     */
    public function getPlace()
    {
        return $this->place;
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
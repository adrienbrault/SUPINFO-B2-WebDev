<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\SubFamily
 */
class SubFamily
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
     * @var Supinfo\WebBundle\Entity\SubFamilyField
     */
    private $fields;

    /**
     * @var Supinfo\WebBundle\Entity\Family
     */
    private $family;

    public function __construct()
    {
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add fields
     *
     * @param Supinfo\WebBundle\Entity\SubFamilyField $fields
     */
    public function addFields(\Supinfo\WebBundle\Entity\SubFamilyField $fields)
    {
        $this->fields[] = $fields;
    }

    /**
     * Get fields
     *
     * @return Doctrine\Common\Collections\Collection $fields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set family
     *
     * @param Supinfo\WebBundle\Entity\Family $family
     */
    public function setFamily(\Supinfo\WebBundle\Entity\Family $family)
    {
        $this->family = $family;
    }

    /**
     * Get family
     *
     * @return Supinfo\WebBundle\Entity\Family $family
     */
    public function getFamily()
    {
        return $this->family;
    }

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * @var Supinfo\WebBundle\Entity\Article
     */
    private $articles;


    /**
     * Add articles
     *
     * @param Supinfo\WebBundle\Entity\Article $articles
     */
    public function addArticles(\Supinfo\WebBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;
    }

    /**
     * Get articles
     *
     * @return Doctrine\Common\Collections\Collection $articles
     */
    public function getArticles()
    {
        return $this->articles;
    }

    public function setFields($fields)
    {
        if (empty($fields)) {
            $this->fields->clear();
        } else {
            foreach ($fields as $field) {
                $this->fields->add($field);
            }
        }
    }
}
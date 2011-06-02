<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\SubFamilyFieldValue
 */
class SubFamilyFieldValue
{
    /**
     * @var integer $subFamilyFieldId
     */
    private $subFamilyFieldId;

    /**
     * @var integer $articleId
     */
    private $articleId;

    /**
     * @var string $value
     */
    private $value;

    /**
     * @var Supinfo\WebBundle\Entity\SubFamilyField
     */
    private $subFamilyField;

    /**
     * @var Supinfo\WebBundle\Entity\Article
     */
    private $article;


    public function __construct(array $values = array())
    {
        if (array_key_exists('subFamilyField', $values)) {
            $this->setSubFamilyField($values['subFamilyField']);
        }
        if (array_key_exists('article', $values)) {
            $this->setArticle($values['article']);
        }
    }


    /**
     * Get subFamilyFieldId
     *
     * @return integer $subFamilyFieldId
     */
    public function getSubFamilyFieldId()
    {
        return $this->subFamilyFieldId;
    }

    /**
     * Get articleId
     *
     * @return integer $articleId
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set subFamilyField
     *
     * @param Supinfo\WebBundle\Entity\SubFamilyField $subFamilyField
     */
    public function setSubFamilyField(\Supinfo\WebBundle\Entity\SubFamilyField $subFamilyField)
    {
        $this->subFamilyField = $subFamilyField;
        $this->subFamilyFieldId = $this->subFamilyField->getId();
    }

    /**
     * Get subFamilyField
     *
     * @return Supinfo\WebBundle\Entity\SubFamilyField $subFamilyField
     */
    public function getSubFamilyField()
    {
        return $this->subFamilyField;
    }

    /**
     * Set article
     *
     * @param Supinfo\WebBundle\Entity\Article $article
     */
    public function setArticle(\Supinfo\WebBundle\Entity\Article $article)
    {
        $this->article = $article;
        $this->articleId = $this->article->getId();
    }

    /**
     * Get article
     *
     * @return Supinfo\WebBundle\Entity\Article $article
     */
    public function getArticle()
    {
        return $this->article;
    }

    public function __toString()
    {
        return (string)$this->getArticleId().'_'.(string)$this->getSubFamilyFieldId();
    }
}
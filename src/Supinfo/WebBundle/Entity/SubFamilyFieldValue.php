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
     * @var Supinfo\WebBundle\Entity\SubFamilyField
     */
    private $subFamilyField;

    /**
     * @var Supinfo\WebBundle\Entity\Article
     */
    private $article;


    /**
     * Set subFamilyFieldId
     *
     * @param integer $subFamilyFieldId
     */
    public function setSubFamilyFieldId($subFamilyFieldId)
    {
        $this->subFamilyFieldId = $subFamilyFieldId;
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
     * Set articleId
     *
     * @param integer $articleId
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
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
     * Set subFamilyField
     *
     * @param Supinfo\WebBundle\Entity\SubFamilyField $subFamilyField
     */
    public function setSubFamilyField(\Supinfo\WebBundle\Entity\SubFamilyField $subFamilyField)
    {
        $this->subFamilyField = $subFamilyField;
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
}
<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\ArticleLoan
 */
class ArticleLoan
{
    /**
     * @var integer $loanId
     */
    private $loanId;

    /**
     * @var integer $articleId
     */
    private $articleId;

    /**
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @var Supinfo\WebBundle\Entity\Article
     */
    private $article;

    /**
     * @var Supinfo\WebBundle\Entity\Loan
     */
    private $loan;


    /**
     * Set loanId
     *
     * @param integer $loanId
     */
    public function setLoanId($loanId)
    {
        $this->loanId = $loanId;
    }

    /**
     * Get loanId
     *
     * @return integer $loanId
     */
    public function getLoanId()
    {
        return $this->loanId;
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

    /**
     * Set loan
     *
     * @param Supinfo\WebBundle\Entity\Loan $loan
     */
    public function setLoan(\Supinfo\WebBundle\Entity\Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Get loan
     *
     * @return Supinfo\WebBundle\Entity\Loan $loan
     */
    public function getLoan()
    {
        return $this->loan;
    }
}
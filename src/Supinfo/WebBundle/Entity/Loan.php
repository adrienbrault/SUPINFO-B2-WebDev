<?php

namespace Supinfo\WebBundle\Entity;

/**
 * Supinfo\WebBundle\Entity\Loan
 */
class Loan
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $reason
     */
    private $reason;

    /**
     * @var date $dateStart
     */
    private $dateStart;

    /**
     * @var date $dateEnd
     */
    private $dateEnd;

    /**
     * @var Supinfo\WebBundle\Entity\User
     */
    private $user;


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
     * Set reason
     *
     * @param text $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Get reason
     *
     * @return text $reason
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set dateStart
     *
     * @param date $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
    }

    /**
     * Get dateStart
     *
     * @return date $dateStart
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param date $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * Get dateEnd
     *
     * @return date $dateEnd
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set user
     *
     * @param Supinfo\WebBundle\Entity\User $user
     */
    public function setUser(\Supinfo\WebBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Supinfo\WebBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return (string)$this->getId();
    }

    public function getDisplayId()
    {
        return sprintf('5%05s', $this->getId());
    }
    /**
     * @var Supinfo\WebBundle\Entity\ArticleLoan
     */
    private $articlesLoan;

    public function __construct()
    {
        $this->articlesLoan = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add articlesLoan
     *
     * @param Supinfo\WebBundle\Entity\ArticleLoan $articlesLoan
     */
    public function addArticlesLoan(\Supinfo\WebBundle\Entity\ArticleLoan $articlesLoan)
    {
        $this->articlesLoan[] = $articlesLoan;
    }

    /**
     * Get articlesLoan
     *
     * @return Doctrine\Common\Collections\Collection $articlesLoan
     */
    public function getArticlesLoan()
    {
        return $this->articlesLoan;
    }

    public function setArticlesLoan($articlesLoan)
    {
        $this->articlesLoan = $articlesLoan;
    }
}
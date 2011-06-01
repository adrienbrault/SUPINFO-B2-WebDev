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
        return $this->getId();
    }
}
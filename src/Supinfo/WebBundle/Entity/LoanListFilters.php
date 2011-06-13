<?php

namespace Supinfo\WebBundle\Entity;

class LoanListFilters
{
    protected $filters = array();

    public function setFilters(array $filters)
    {
        $this->filters = $filters;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function __construct($filters = null)
    {
        if (is_array($filters)) {
            $this->filters = $filters;
        } else if (is_string($filters)) {
            $this->filters = array_map('intval', explode(self::getURISeperator(), $filters));
        }
    }

    public function getFiltersURI()
    {
        return implode($this->getFilters(), self::getURISeperator());
    }

    static function getFiltersChoices()
    {
        return array(
            'Ended',
            'Ongoing',
            'Upcoming'
        );
    }

    static function getURISeperator()
    {
        return '-';
    }
}
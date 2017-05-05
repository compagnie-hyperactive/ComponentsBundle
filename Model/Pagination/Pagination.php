<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 05/05/17
 * Time: 10:33
 */

namespace Lch\ComponentsBundle\Model\Pagination;


use Lch\ComponentsBundle\Exception\Pagination\IncoherentPageDataException;

class Pagination
{
    const PAGE = 'page';
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $totalpageCount;

    /**
     * @var int
     */
    private $maxResultsPerPage;

    /**
     * @var string
     */
    private $route;

    /**
     * @var array
     */
    private $routeParameters;

    /**
     * Pagination constructor.
     * @param int $page
     * @param int $totalPageCount
     * @param int $maxResultsPerPage
     * @param string $route
     * @param array $routeParameters
     */
    public function __construct(int $page, int $totalPageCount, int $maxResultsPerPage, string $route, array $routeParameters = []) {
        
        if($page > $totalPageCount) {
            throw new IncoherentPageDataException("Current page number is greater than total pages count.");
        }
        $this->page = $page;
        $this->totalpageCount = $totalPageCount;
        $this->maxResultsPerPage = $maxResultsPerPage;
        $this->route = $route;
        $this->routeParameters = $routeParameters;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return Pagination
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalpageCount()
    {
        return $this->totalpageCount;
    }

    /**
     * @param int $totalpageCount
     * @return Pagination
     */
    public function setTotalpageCount($totalpageCount)
    {
        $this->totalpageCount = $totalpageCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return Pagination
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return array
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    /**
     * @param array $routeParameters
     * @return Pagination
     */
    public function setRouteParameters($routeParameters)
    {
        $this->routeParameters = $routeParameters;
        return $this;
    }
}
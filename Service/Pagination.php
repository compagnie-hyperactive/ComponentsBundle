<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 05/05/17
 * Time: 10:32
 */

namespace Lch\ComponentsBundle\Service;

use Lch\ComponentsBundle\Model\Pagination\Pagination as PaginationObject;
use Symfony\Component\HttpFoundation\Request;

class Pagination
{
    /**
     * @var int
     */
    private $maxResultsPerPage;

    public function __construct(int $maxResultsPerPage) {
        $this->maxResultsPerPage = $maxResultsPerPage;
    }

    /**
     * @param int $totalEntityNumber
     * @param int $page
     * @param string $route
     * @param array $routeParameters
     * @return PaginationObject
     */
    public function getPagination(int $totalEntityNumber, int $page, string $route, array $routeParameters = []) {
        return new PaginationObject(
            $page,
            ceil($totalEntityNumber / $this->maxResultsPerPage),
            $this->maxResultsPerPage,
            $route,
            $routeParameters
        );
    }
    
    public function getCurrentPage(Request $request) {
        return $request->query->has(PaginationObject::PAGE) ?$request->query->get(PaginationObject::PAGE) : 1;
    }
}
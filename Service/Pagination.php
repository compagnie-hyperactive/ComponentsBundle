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
     * Pagination constructor.
     */
    public function __construct() {
    }

    /**
     * @param int $totalEntityNumber
     * @param int $page
     * @param int $maxResultsPerPage
     * @param string $route
     * @param array $routeParameters
     * @return PaginationObject
     */
    public function getPagination(int $totalEntityNumber, int $page, int $maxResultsPerPage, string $route, array $routeParameters = []) {
        return new PaginationObject(
            $page,
            ceil($totalEntityNumber / $maxResultsPerPage),
            $maxResultsPerPage,
            $route,
            $routeParameters
        );
    }
    
    public function getCurrentPage(Request $request) {
        return $request->query->has(PaginationObject::PAGE) ?$request->query->get(PaginationObject::PAGE) : 1;
    }
}
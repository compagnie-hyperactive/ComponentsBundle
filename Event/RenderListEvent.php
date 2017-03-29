<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/05/15
 * Time: 16:01
 */
namespace Lch\ComponentsBundle\Event;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RenderListEvent extends ListEvent
{

    /**
     * @var The list records
     */
    private $records;

    /**
     * @var TokenInterface $token
     */
    private $token;

    /**
     * @param $records
     * @param array $options
     * @param TokenInterface $token
     */
    public function __construct($records, array $options, TokenInterface $token)
    {
        $this->records = $records;
        $this->token = $token;

        parent::__construct($options);
    }

    /**
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param $records
     * @return RenderListEvent
     */
    public function setRecords($records)
    {
        $this->records = $records;
        return $this;
    }
}
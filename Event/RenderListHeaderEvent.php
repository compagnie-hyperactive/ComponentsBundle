<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/05/15
 * Time: 16:01
 */
namespace Lch\ComponentsBundle\Event;


class RenderListHeaderEvent extends ListEvent
{
    /**
     * @var  The list records
     */
    private $records;


    /**
     * @param  $records
     * @param array $options
     */
    public function __construct( $records, array $options)
    {
        $this->records = $records;
        parent::__construct($options);
    }

    /**
     * @return 
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param  $records
     * @return RenderListHeaderEvent
     */
    public function setRecords($records)
    {
        $this->records = $records;
        return $this;
    }
}
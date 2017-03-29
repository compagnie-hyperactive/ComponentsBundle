<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/05/15
 * Time: 16:01
 */
namespace Lch\ComponentsBundle\Event;


class RenderListEventAfter extends ListEvent
{

    /**
     * @var The list records
     */
    private $records;

    /**
     * @var string the HTML output to display before list
     */
    private $output;

    /**
     * @param $records
     * @param array $options
     */
    public function __construct($records, array $options)
    {
        $this->records = $records;
        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param string $output
     * @return RenderListEventBefore
     */
    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
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

    /**
     * @param $output string HTML fragment to display
     * @return $this
     */
    public function addOutput($output) {
        $this->output .= $output;
        return $this;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nbonniot
 * Date: 16/09/16
 * Time: 16:10
 */

namespace Lch\ComponentsBundle\Model;


class FieldState
{

    /**
     * State inactive for 0, active for 1
     */
    const NORMAL = 0;

    /**
     * State active for 0, inactive for 1
     */
    const INVERTED = 0;
}
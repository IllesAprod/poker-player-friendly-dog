<?php
require_once __DIR__ . '/Rule.php';

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 15:13
 */
class StraightFlushRule implements Rule
{

    public function isApplicable(Hand $hand)
    {
        return false;
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }
}
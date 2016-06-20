<?php
namespace Medialib\PropTypes\Domain\Model;
/*
 * This file is part of the Medialib.PropTypes package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
use Assert\Assertion;

/**
 * Any PropType
 *
 * @api
 */
class AnyPropType implements PropTypeInterface
{
    /**
     * @var object
     */
    protected $value;

    /**
     * @param mixed $value
     * @param boolean $required
     */
    public function __construct($value  = null, $required = false)
    {
        $required === false ? true : Assertion::notNull($value);
        $this->value = $value;
    }

}

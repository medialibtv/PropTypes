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
use TYPO3\Flow\Annotations as Flow;

/**
 * PropTypes
 *
 * @api
 * @Flow\Proxy(false)
 */
class Expression
{
    const T_STRING = 'string';
    const T_NUMBER = 'number';
    const T_OBJECT = 'object';
    const T_FUNC = 'func';
    const T_BOOL = 'bool';
    const T_ANY = 'any';


    const T_ONE_OF = 'oneOf';
    const T_ONE_OF_TYPE = 'oneOfType';

    const T_ARRAY = 'array';
    const T_ARRAY_OF = 'arrayOf';

    const T_INSTANCE_OF = 'instanceOf';

    const T_SHAPE = 'shape';

    const O_IS_REQUIRED = 'isRequired';

    /**
     * @return array
     */
    public static function allowedTypes()
    {
        return [
            self::T_STRING,
            self::T_NUMBER,
            self::T_OBJECT,
            self::T_FUNC,
            self::T_BOOL,
            self::T_ANY,
            self::T_ONE_OF,
            self::T_ONE_OF_TYPE,
            self::T_ARRAY,
            self::T_ARRAY_OF,
            self::T_INSTANCE_OF,
            self::T_SHAPE
        ];
    }

    public static function allowedOptions()
    {
        return [
            self::O_IS_REQUIRED
        ];
    }
}

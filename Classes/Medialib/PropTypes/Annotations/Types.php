<?php
namespace Medialib\PropTypes\Annotations;
    /*
     * This file is part of the Medialib.PropTypes package.
     *
     * (c) Contributors of the Neos Project - www.neos.io
     *
     * This package is Open Source Software. For the full copyright and license
     * information, please view the LICENSE file which was distributed with this
     * source code.
     */

/**
 * Types
 *
 * @Annotation
 * @Target("CLASS")
 */
final class Types
{
    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->configuration = $values;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}

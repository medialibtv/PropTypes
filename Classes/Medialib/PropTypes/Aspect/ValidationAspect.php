<?php
namespace Medialib\PropTypes\Aspect;

/*
 * This file is part of the Medialib.PropTypes package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
use Medialib\PropTypes\Exception;
use Medialib\PropTypes\ValidationService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Aspect
 * @Flow\Scope("singleton")
 */
class ValidationAspect
{
    /**
     * @var ValidationService
     * @Flow\Inject
     */
    protected $accountService;

    /**
     * @Flow\Before("classAnnotatedWith(Medialib\PropTypes\Annotations\Types) && method(.*->__construct())")
     * @param JoinPointInterface $joinPoint The current join point
     * @return string
     * @throws Exception
     */
    public function validate(JoinPointInterface $joinPoint)
    {
        list($propertyName, $properties) = $this->validationJoinPointArgument($joinPoint);
        $this->accountService->validate($joinPoint->getClassName(), $properties);
    }

    /**
     * @Flow\Before("classAnnotatedWith(Medialib\PropTypes\Annotations\Defaults) && method(.*->__construct())")
     * @param JoinPointInterface $joinPoint The current join point
     * @return string
     * @throws Exception
     */
    public function enforceDefaults(JoinPointInterface $joinPoint)
    {
        list($propertyName, $properties) = $this->validationJoinPointArgument($joinPoint);
        $properties = $this->accountService->enforceDefaults($joinPoint->getClassName(), $properties);
        $joinPoint->setMethodArgument($propertyName, $properties);
    }

    /**
     * @param JoinPointInterface $joinPoint
     * @return array
     * @throws Exception
     */
    protected function validationJoinPointArgument(JoinPointInterface $joinPoint)
    {
        $properties = $joinPoint->getMethodArguments();
        $propertyNames = array_keys($properties);
        if (count($properties) > 1) {
            throw new Exception('Only constructor with a single parameter is supported', 1466432377);
        }
        $properties = array_shift($properties);
        $propertyName = array_shift($propertyNames);
        if (!is_array($properties)) {
            throw new Exception(sprintf('Constructor parameter "%s" must be an array', $propertyName), 1466432401);
        }
        return [$propertyName, $properties];
    }
}

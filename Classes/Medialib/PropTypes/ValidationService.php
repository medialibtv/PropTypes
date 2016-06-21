<?php
namespace Medialib\PropTypes;

/*
 * This file is part of the Medialib.PropTypes package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
use Medialib\PropTypes\Annotations\Defaults;
use Medialib\PropTypes\Annotations\Types;
use Medialib\PropTypes\Domain\Model\Expression;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Object\ObjectManagerInterface;
use TYPO3\Flow\Reflection\ReflectionService;

/**
 * Validation Service
 *
 * @Flow\Scope("singleton")
 */
class ValidationService
{
    /**
     * @var ReflectionService
     * @Flow\Inject
     */
    protected $reflectionService;

    /**
     * @var ObjectManagerInterface
     * @Flow\Inject
     */
    protected $objectManager;

    /**
     * @var array
     * @Flow\Inject(setting="validationImplementation", package="Medialib.PropTypes")
     */
    protected $settings;

    /**
     * @param string $className
     * @param array $properties
     * @return void
     */
    public function validate($className, array $properties)
    {
        /** @var Types $annotation */
        $annotation = $this->reflectionService->getClassAnnotation($className, '\Medialib\PropTypes\Annotations\Types');
        $configuration = $annotation->getConfiguration();
        foreach ($configuration as $propertyName => $expression) {
            $propertyValue = isset($properties[$propertyName]) ? $properties[$propertyName] : null;
            $this->validateProperty($propertyName, $propertyValue, $expression);
        }
    }

    /**
     * @param string $className
     * @param array $properties
     * @return array
     */
    public function enforceDefaults($className, array $properties)
    {
        /** @var Defaults $annotation */
        $annotation = $this->reflectionService->getClassAnnotation($className, '\Medialib\PropTypes\Annotations\Defaults');
        $defaults = $annotation->getConfiguration();
        foreach ($defaults as $propertyName => $propertyValue) {
            if (isset($properties[$propertyName])) {
                continue;
            }
            switch ($propertyValue) {
                case 'true':
                    $propertyValue = true;
                    break;
                case 'false':
                    $propertyValue = false;
                    break;
                case 'null':
                    $propertyValue = null;
                    break;
            }
            $properties[$propertyName] = $propertyValue;
        }

        return $properties;
    }

    /**
     * @param string $propertyName
     * @param string $propertyValue
     * @param string $expression
     * @throws Exception
     * @throws InvalidArgumentException
     */
    protected function validateProperty($propertyName, $propertyValue, $expression)
    {
        $expression = explode('.', $expression, 2);
        $type = $expression[0];
        if (!in_array($type, Expression::allowedTypes())) {
            throw new Exception(sprintf('Invalid type "%s"', $type), 1466432741);
        }
        if (!isset($this->settings[$type])) {
            throw new Exception(sprintf('Type "%s" implementation not found', $type), 1466432749);
        }
        $options = isset($expression[1]) ? explode('.', $expression[1], 2) : [];
        array_map(function ($option) {
            if (!in_array($option, Expression::allowedOptions())) {
                throw new Exception(sprintf('Invalid option "%s"', $option), 1466432741);
            }
        }, $options);
        try {
            $isRequired = in_array(Expression::O_IS_REQUIRED, $options, true);
            $this->objectManager->get($this->settings[$type], $propertyValue, $isRequired);
        } catch (\InvalidArgumentException $exception) {
            $message = sprintf('Validation exception for "%s" property: %s', $propertyName, $exception->getMessage());
            throw new InvalidArgumentException($message, 1466432286, $exception);
        }
    }
}

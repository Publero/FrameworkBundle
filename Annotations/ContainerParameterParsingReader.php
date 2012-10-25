<?php
namespace Publero\FrameworkBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Publero\FrameworkBundle\Traits\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ContainerParameterParsingReader implements Reader, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param string $readerClass
     */
    public function __construct($readerClass)
    {
        $this->reader = new $readerClass();
    }

    public function getClassAnnotations(\ReflectionClass $class)
    {
        return $this->parse($this->reader->getClassAnnotations($class));
    }

    public function getClassAnnotation(\ReflectionClass $class, $annotationName)
    {
        return $this->parse($this->reader->getClassAnnotation($class, $annotationName));
    }

    public function getMethodAnnotations(\ReflectionMethod $method)
    {
        return $this->parse($this->reader->getMethodAnnotations($method));
    }

    public function getMethodAnnotation(\ReflectionMethod $method, $annotationName)
    {
        return $this->parse($this->reader->getMethodAnnotation($method, $annotationName));
    }

    public function getPropertyAnnotations(\ReflectionProperty $property)
    {
        return $this->parse($this->reader->getPropertyAnnotations($property));
    }

    public function getPropertyAnnotation(\ReflectionProperty $property, $annotationName)
    {
        return $this->parse($this->reader->getPropertyAnnotation($property, $annotationName));
    }

    /**
     * @param mixed $annot
     * @return mixed
     */
    public function parse($annotation)
    {
        if ($annotation === null) {
            return null;
        }

        if (is_array($annotation)) {
            foreach ($annotation as $key => $item) {
                $annot[$key] = $this->parse($item);
            }

            return $annotation;
        }

        if (is_string($annotation)) {
            return $this->container->getParameterBag()->resolveValue($annotation);
        }

        if (is_object($annotation)) {
            $parameterBag = $this->container->getParameterBag();
            foreach (get_object_vars($annotation) as $key => $value) {
                if (is_string($value)) {
                    $annotation->$key = $parameterBag->resolveValue($value);
                }
            }
        }

        return $annotation;
    }
}

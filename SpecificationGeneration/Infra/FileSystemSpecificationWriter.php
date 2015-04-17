<?php

namespace Gmorel\StateWorkflowBundle\SpecificationGeneration\Infra;

use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\Representation\SpecificationRepresentationInterface;
use Gmorel\StateWorkflowBundle\SpecificationGeneration\Domain\SpecificationWriterInterface;
use SpecificationGeneration\Domain\Exception\UnableToWriteSpecificationException;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class FileSystemSpecificationWriter implements SpecificationWriterInterface
{
    /**
     * {@inheritdoc}
     * @param string $target Directory
     */
    public function write(SpecificationRepresentationInterface $specificationRepresentation, $target)
    {
        if (empty($target)) {
            throw new UnableToWriteSpecificationException(
                sprintf(
                    'Unable to write the specification because target path is empty.',
                    $target
                )
            );
        }

        $renderedSpecification = $specificationRepresentation->render();

        $this->guardAgainstEmptyRenderedSpecification($target, $renderedSpecification);

        $this->createDirectoryIfNotExist($target);

        $result = file_put_contents(
            $target,
            $specificationRepresentation->render()
        );

        $this->guardAgainstNotWrittenSpecification($target, $result);
    }

    /**
     * @param string $directory
     */
    private function createDirectoryIfNotExist($directory)
    {
        if (!is_dir(dirname($directory))) {
            mkdir(dirname($directory), 0777, true);
        }
    }

    /**
     * @param string $target
     * @param string $renderedSpecification
     */
    private function guardAgainstEmptyRenderedSpecification($target, $renderedSpecification)
    {
        if (empty($renderedSpecification)) {
            throw new UnableToWriteSpecificationException(
                sprintf(
                    'Unable to write the specification on "%s" because specification was rendered as an empty string.',
                    $target
                )
            );
        }
    }

    /**
     * @param string   $target
     * @param bool|int $result
     */
    private function guardAgainstNotWrittenSpecification($target, $result)
    {
        if (false === $result) {
            throw new UnableToWriteSpecificationException(
                sprintf(
                    'Unable to write the specification on "%s".',
                    $target
                )
            );
        }
    }

}

<?php

namespace Gmorel\StateWorkflowBundle\StateEngine\Exception;

/**
 * Occurs when someone tries to use a workflow containing no State
 * @author Guillaume MOREL <github.com/gmorel>
 */
class EmptyWorkflow extends \DomainException
{

}

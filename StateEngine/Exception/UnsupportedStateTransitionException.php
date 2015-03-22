<?php

namespace Gmorel\StateWorkflowBundle\StateEngine\Exception;

/**
 * Occurs when someone tries to perform an illegal State Action on an Entity
 * @author Guillaume MOREL <github.com/gmorel>
 */
class UnsupportedStateTransitionException extends \DomainException
{

}

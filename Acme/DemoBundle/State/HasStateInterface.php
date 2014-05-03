<?php
/**
 * Created by PhpStorm.
 * Date: 4/4/14
 * Time: 9:14 AM
 * 
 * @author Guillaume MOREL <github.com/gmorel>
 */

namespace Acme\DemoBundle\State;

/**
 * Interface HasStateInterface
 * Allow an object to have a State
 */
interface HasStateInterface
{
    /**
     * Set Item status
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get Item status
     *
     * @return string
     */
    public function getStatus();
} 
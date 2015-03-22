<img src ="https://raw.githubusercontent.com/gmorel/StateWorkflowBundle/master/doc/StateWorkflowBundle-logo.png" alt="StateWorkflowBundle logo" align="right"/>
State Workflow Bundle
=====================

[![Build Status](https://travis-ci.org/gmorel/StateWorkflowBundle.svg?branch=master)](https://travis-ci.org/gmorel/StateWorkflowBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gmorel/StateWorkflowBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gmorel/StateWorkflowBundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gmorel/StateWorkflowBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gmorel/StateWorkflowBundle/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/55460bb35d4f9a44c60000d3/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55460bb35d4f9a44c60000d3)
[![Latest Stable Version](https://poser.pugx.org/gmorel/state-workflow-bundle/v/stable.svg)](https://packagist.org/packages/gmorel/state-workflow-bundle)
[![License](https://poser.pugx.org/gmorel/state-workflow-bundle/license)](https://packagist.org/packages/gmorel/state-workflow-bundle)

<img src ="https://raw.githubusercontent.com/spec-gen/state-workflow-spec-gen-bundle/master/doc/symfony.png" alt="Symfony 2" align="right"/>
Helping you implementing a complex yet easily maintainable workflow.
---------------------------------------------

Keywords : State Design Pattern, Workflow, Finite State Machine, Symfony2

![Workflow](https://raw.githubusercontent.com/gmorel/StateWorkflowBundle/master/doc/demo-booking-workflow.png "Workflow")


Our [StateWorkflow](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/StateWorkflow.php) object is responsible for managing all your `States` and their `Transitions` for your given `Entity` implementing [HasStateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/HasStateInterface.php#L9).
Every single State is a class implementing our [StateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/StateInterface.php#L10-10) and is managing its own transitions.


### Ubiquitous Language
- **State** : an Entity finite state at a given time (ex: `Booking payed`, `Quote cancelled`, etc..)
- **Transition** : a transition between state A and state B (ex: Booking waiting for payment --`Send confirmation mail`-> Booking payed, etc..)


### Pros
- All your workflow is described via classes
- Each State is responsible for **its own transitions**
- Each State Transition can **contain logic** (Log, Event Sourcing, Assertion, Send mail, etc..)
- States are Symfony2 services
- All your workflow can be easily **Unit Tested**
- Entity's current state can be easily stored in database (simple string)
- Workflow **specification file can be [generated](https://github.com/spec-gen/state-workflow-spec-gen-bundle) from code base**


### Cons
- Each time you add a transition you have to modify your [own](https://github.com/gmorel/StateWorkflowDemo/blob/master/src/BookingEngine/Domain/State/BookingStateInterface.php#L44-44) interface extending our [StateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/StateInterface.php#L10-10) implementation
- If you only need a Finite State Machine without logic in your transitions. You might prefer https://github.com/yohang/Finite
- Not really following the famous precept : "prefer composition over inheritance" ..



### Usage

```php
$bookingWorkflow = $this->get('demo.booking_engine.state_workflow');

// Initialize entity state to booking workflow default state : incomplete
// `Booking::__construct` contains `$bookingWorkflow->getDefaultState()->initialize($this);`
$booking = new Booking($bookingWorkflow, 200);

// Set incomplete Booking as paid
// Take care of the state transition (incomplete -> paid) - Send confirmation mail
$booking->getState($bookingWorkflow)
    ->setBookingAsPaid($booking);

// Get current booking state : StatePaid
$currentState = $booking->getState($bookingWorkflow);
```

With this Service declarations 

```xml
<!-- Booking Workflow -->
<service id="demo.booking_engine.state_workflow" class="Gmorel\StateWorkflowBundle\StateEngine\StateWorkflow" public="false">
    <argument>Booking Workflow</argument>
    <argument>demo.booking_engine.state_workflow</argument>
    <tag name="gmorel.state_workflow_bundle.workflow" />
</service>

<!-- Booking States -->
<service id="demo.booking_engine.state.incomplete" class="BookingEngine\Domain\State\Implementation\StateIncomplete" public="false">
    <tag name="demo.booking_engine.state" />
</service>

<service id="demo.booking_engine.state.waiting_payment" class="BookingEngine\Domain\State\Implementation\StateWaitingPayment" public="false">
    <tag name="demo.booking_engine.state" />
</service>

<!-- ... -->
```

### Implementation example

Booking Demo https://github.com/gmorel/StateWorkflowDemo

### Details

It will allow you to manage `States` and especially their available `Transitions` for an `Entity` (for example a Booking class) implementing our interface [HasStateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/HasStateInterface.php#L9-9).
It is aiming at helping implementing a complex `Workflow` where each `State` implementing our interface [StateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/StateInterface.php#L10-10) is responsible for its `Transitions` (methods) to other `States`.
Some `Transitions` being impossible (not part of your `Workflow`) and then throwing the exception [UnsupportedStateTransitionException](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/Exception/UnsupportedStateTransitionException.php#L9-9) whenever called.

Each `State` has a [Symfony2 service](http://symfony.com/doc/current/book/service_container.html#what-is-a-service) [tag](http://symfony.com/doc/current/book/service_container.html#tags):
```xml
<service id="demo.booking_engine.state.paid" class="BookingEngine\Domain\State\Implementation\StatePaid" public="false">
    <tag name="demo.booking_engine.state" />
</service>
```
This way you will be able to manage available `States` for different `Entities` by using other [Symfony2 tags](http://symfony.com/doc/current/book/service_container.html#tags) since Booking, Content and Customer entities shall not share the same `Workflow`/`States`). 
You will then need to modify the [Symfony2 CompilerPass](http://symfony.com/doc/current/cookbook/service_container/compiler_passes.html) in order to let your `Workflow` be aware of its `States`.

#### Adding new State:

In case you wish to add a new `State` you will need to create a new Class implementing our interface [StateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/StateInterface.php#L10-10).

#### Adding new Transition:

In case you wish to add a new `Transition` you will need to add a new method in your [XXXStateInterface](https://github.com/gmorel/StateWorkflowDemo/blob/master/src/BookingEngine/Domain/State/BookingStateInterface.php#L44-44) extending our [StateInterface](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/StateInterface.php#L10-10). 
You can also use our helper [AbstractState](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/AbstractState.php#L15-15) which would implement default behavior ie. a method throwing our [UnsupportedStateTransitionException](https://github.com/gmorel/StateWorkflowBundle/blob/master/StateEngine/Exception/UnsupportedStateTransitionException.php#L9-9).


#### Installation

##### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require gmorel/state-workflow-bundle "~1.0"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

##### Step 2: Enable the Bundle

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Gmorel\StateWorkflowBundle\GmorelStateWorkflowBundle(),
        );
        // ...
    }

    // ...
}
```

#### How it works internally

![UML](https://raw.githubusercontent.com/gmorel/StateWorkflowBundle/master/doc/uml-statebundle-simplified.png "UML")


Credits
=======

- [State Design Pattern](https://sourcemaking.com/design_patterns/state)

Licence
=======

MIT License (MIT)

Contributing
============

Feel free to enhance it and to share your ideas/enhancements.

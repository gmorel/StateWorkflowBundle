Symfony2 - Design Pattern Example - State
=========================================

Example of a way to implement the State design pattern in a Symfony2 project
Helping you managing a complex but easily maintainable workflow.


## Design Pattern presentation

"The state pattern, which closely resembles Strategy Pattern, is a behavioral software design pattern, also known as the objects for states pattern.
This pattern is used in computer programming to encapsulate varying behavior for the same routine based on an object's state object.
This can be a cleaner way for an object to change its behavior at runtime without resorting to large monolithic conditional statements."
source: Wikipedia

## Details

Basically it will allow you to manage States and especially their Transitions available for an object (for example a product class) implementing the ```HasStateInterface``` interface.
This will allow you to implement a complex workflow where each State implementing the ```StateInterface``` interface is responsible for its transitions to other states.
Some transition being impossible (not part of your workflow) and then throwing the ```UnsupportedStateActionException``` exception.

Each State is a service tagged as ```acme.demo.default.state```.
This way you will be able to manage available States for different resources by using other tags.

## Example

Example workflow:
- StateA -> transition() -> StateB
- StateIncomplete -> create()    -> StateWaitingPayment
                  -> setAsPaid() -> StatePaid
- StateWaitingPayment -> setAsIncomplete() -> StateIncomplete
                      -> setAsPaid()       -> StatePaid
                      -> cancel()          -> StateCancelled
- StatePaid -> cancel() -> StateCancelled -> setStateHavingNoTransition() -> StateToDelete

## Usage

```php

$stateManager = $this->get('acme.demo.state.manager');

// Init State with default value StateIncomplete (StateIncomplete::key = 0)
$item = $stateManager->initState($item);

/** @var StateInterface $status **/
$status = $stateManager->getCurrentState($item);

$item = $status->setAsPaid($item);
// setAsPaid() Transition initiated and $item State changed


```

## Credits

The code is given as an example. Feel free to enhance it. And to share you ideas/enhancements.
Licence: MIT
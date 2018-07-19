# CQRS

## with CQRS

* controler -> call bus with an action -> return bus'return

* action -> has his associated handler

* bus -> contructor -> make handler referential (all service which implement a certain interface)
* bus -> handle -> call middleware -> call handler -> call event handler -> return result

* handler -> implement interface to have the function the bus need to call
* handler -> do whatever you want <3 (db action or even other event)

## without CQRS

* controller -> do action (as handler) -> return result
* event listener -> detect before action -> launch other action (as middleware)
* event listener -> detect after action -> launch other action (as event handler)

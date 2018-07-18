ddd_and_cqrs.md

https://www.youtube.com/watch?v=qBLtZN3p3FU

CQRS, Fonctionnel, Event Sourcing & Domain Driven Design - Arnaud Lemaire - PHP Tour 2018

# why CQRS

data driven vs domain driven
what data vs what behavior
crud architecture vs task based ui

with crud
adress edition
	-> mistake ?
	-> or relocation ?
	-> user intend is lost
	-> with a bit of humor "do you want to have as much added value than an access database ?"

data driven - entities
 * subscription plan
 * subscription
 * membership
 * session

behavior driven - uses case (what system have to be able to do)
 * CreateSubscriptionPlan
 * Subscribe
 * SubscribeGrossRevenue
 * StartSession

no need data, but know what the system need to do
you don't need to have the full corrects lists, just enougth to get started

# datatype

the domain is express through plain old php object categorized between entities and value object
 * entities: equality on identity, clasic, has lifecycle, born, live, die (subscription, membership, session)
 * value object: equality on values, has no lifecycle (datetime, money, BillingInterval)

## aggregate

organized by aggregate
agregate : some object to represent a business concept
aggregate root : 
 * an objetc which will be the root of the concept, 
 * which will coordinate some other entities and values objects 
 * (operations can only be performed through the root). 
 * agregate root will enforce integrity of the rest of the agregate
 * aggregate object's share a common lifecycle: they can be fetched as a whole

# how isorganised

uses cases are discriminated between command (write, mutation) & queries (read)

## Command

a command is a DTO ?
```CreateSubscriptionPlanCommand```
```CreateSubscriptionPlanCommandHandler```
a command is associate to an handle, which will do business associate action. In the handler we give colaborator in the constructor. Colaborator are necessaraly, interfaces
interfaces permit to change collaborator, and increase maintenability

## CQS - the shared repository
no R because repository is shared between command and query
### query
user <- view model -> query - Handler <-> repository <-> DB
### command
user <- intend -> command - handler <-> repository <-> DB

cqs - the repository
 * domain entity: not orm entities
 * repository: domain interface
 * implementation: can be implemented using doctring
 * DB

```SubscriptionPlanRepository```
```App/Subscription/query/FindActiveSubscriptionPlansQuery```
```App/Subscription/query/FindActiveSubscriptionPlansQueryHandler```

### Bus & Middleware

What if we need to apply common behavior on all command or queries ? bus/middleware from command and queries are separate

#### Command
Command -> Bus - middleware[] (logging, errors, ...) - dispatcher <-> handler
Bus -> (return) ack/nack 

#### Query
Query -> bus -> middleware[] (logging, cache) - dispatcher <-> handler

#### Middleware
```LoggerMiddleware```
In middleware we need to know the next step (next middleware or dispatcher);
```CommandBusDispatcher```
```CommandBusFactory.php```
```src/Kernel.php```
```config/services.yaml```
```PlansRessource```
```DoctrineFlushBusMiddleware```

## Domain event (business side-effects)

commands are intend
events are truth, fact

command -> handler -> acke/nack and domain event
these event are not for a global messaging bus like kafka
local event != global event
```src/App/Membership/Domain/MemberJoined.php```
```JoinMembershipCommandHandler```
```SendWelcomeMailOnMemberJoined```
an event handler is always void, no need to take care of the answer (don t want to make my api crash because of mailer failed)

they are great place to express "business side effects"

command -> bus -> middleware[] -> dispatcher -> handler -event-> dispatcher -> event middleware -> event dispatcher -> event handler

```EventDispatcherBusMiddleware```
```EventBus```

### Projection
prepare data (statistic, legacy database, ...), save data in an other base
```UpdateReferralProgramOnMemberJoined```

## Command Query Responsability Segregation
repository only command side
```SubscriptionPlanRepository (p2)```
```BasketDoctrineRepository```
```FindActiveSubscriptionPlansQueryHandler```

## Event sourcing
all is event, so the handler no need to persist, only event are persist
```Basket```
```BasketEventApplier (trait)```
```SubscriptionPlanRepository (p3)```
```BasketRepository```
```AddProductToBasketCommandHandler```

## Schema

### CQS

#### query
user <- view model -> query - Handler <-> repository <-> DB
#### command
user <- intend -> command - handler <-> repository <-> DB

### CRQS

#### Command
Command -> Bus - middleware[] (logging, errors, ...) - dispatcher <-> handler
Bus -> (return) ack/nack 

#### Query
Query -> bus -> middleware[] (logging, cache) - dispatcher <-> handler

### Event sourcing

command -> bus -> middleware[] -> dispatcher -> handler -event-> dispatcher -> event middleware -> event dispatcher -> event handler

## File 23

### Command & query 5

```src/App/Subscription/Command/CreateSubscriptionPlanCommand.php```
```src/App/Subscription/Command/CreateSubscriptionPlanCommandHandler.php```

```src/App/Subscription/Domain/SubscriptionPlanRepository.php```
```src/App/Subscription/Query/FindActiveSubscriptionPlansQuery.php```
```src/App/Subscription/Query/FindActiveSubscriptionPlansQueryHandler.php```

### Middleware 7

```./LoggerMiddleware.php```
```./CommandBusDispatcher.php```
```CommandBusFactory.php```
```src/Kernel.php```
```config/services.yaml```
```./PlansRessource.php```
```./DoctrineFlushBusMiddleware.php```

### Domain event (business side-effects) 4

```src/App/Membership/Domain/MemberJoined.php```
```src/App/Membership/Command/JoinMembershipCommandHandler.php```
```./SendWelcomeMailOnMemberJoined.php```

```./EventDispatcherBusMiddleware.php```
```./EventBus.php```

### Projection 1

```./UpdateReferralProgramOnMemberJoined.php```

### Command Query Responsability Segregation 3

```src/App/Subscription/Domain/SubscriptionPlanRepository.php (p2)```
```BasketDoctrineRepository.php```
```src/App/Subscription/Query/FindActiveSubscriptionPlansQueryHandler.php P2```

### Event sourcing 5

```Basket```
```BasketEventApplier (trait)```
```SubscriptionPlanRepository (p3)```
```BasketRepository```
```AddProductToBasketCommandHandler```

### Don t know 

query -> controller -> bus -> dispatch -> handler -> result -> response
... a quand les middleware ?

command -> controller -> bus -> dispatch -> handler
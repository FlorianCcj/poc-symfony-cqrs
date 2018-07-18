# gnugat.github.io cqrs

## source

* https://gnugat.github.io/2016/04/27/event-driven-architecture.html
* https://gnugat.github.io/2016/05/18/towards-cqrs-search-engine.html

## Concept

* Command / Query Responsibility Segregation (CQRS)
* Repository design pattern
* Specification design pattern (to make our repository more light)

## Package

use porpaginas'bundle
https://gnugat.github.io/2015/11/05/porpaginas.html

## Example

### example request

```http
GET /v1/profiles?name=marvin&page=42&per_page=23&sort=-name HTTP/1.1
Accept: application/json
```

### example response

```http
HTTP/1.1 200 OK
Content-Type: application/json

{
    "items": [
        {
            "name": "Arthur Dent"
        },
        {
            "name": "Ford Prefect"
        },
        {
            "name": "Trillian Astra"
        }
    ],
    "page": {
        "current_page": 1,
        "per_page": 10,
        "total_elements": 3,
        "total_pages": 1
    }
}
```

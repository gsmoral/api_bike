
<p align="center">
  <a href="https://github.com/gsmoral/api_bike" rel="noopener" target="_blank"><img width="150" src="./laravel-app/public/favicon.ico" alt="API Bike logo"></a>
</p>
<h1 align="center">API Bike</h1>

This project was created with [Laravel](https://laravel.com/docs/10.x/installation).


## Run this project

To run this project perform the following steps

### Clone project

Run:
`https://github.com/gsmoral/podcaster.git`

### Docker

Run:
`docker-compose build` 
and 
`docker-compose up -d`

Connect to Docker container:
`docker exec -it l_app /bin/sh`

Inside container run:
`php artisan migrate --seed`

---

## API

With postman, set headers: **Content-Type: application/json** and **Accept: application/json**

For ***Protected Routes -> *** Use: **Authorization - Bearer Token** witn obtained token in ***Login***

***Response to Unauthenticated:***
`{
    "message": "Unauthenticated."
}`

### POST - Login 

`localhost:8080/api/auth/login`

Body:
```json
{
  "email": "test@example.com",
  "password": "password"
}
```

### GET - Get bikes

`localhost:8080/api/bikes`

Search params for example:
`localhost:8080/api/bikes?name="Mountain"&manufacturer=Technogym&item_type="item_type"&sort=asc`

***Response example:***
```json
{
    "status": true,
    "total": 2,
    "data": [...]
}
```

### GET - Get bike

Response cached.

`localhost:8080/api/bike/1`

***Response example:***
```json
{
    "status": true,
    "data": {
        "id": 1,
        "name": "aperiam",
        "description": "Consequatur sit velit inventore necessitatibus doloribus nulla. Reiciendis id et exercitationem voluptatem quas quae enim. Id alias pariatur ea delectus enim consequatur. Voluptatem nulla consequatur cumque et ducimus magni dicta.",
        "price": "828.95",
        "manufacturer": "Toorx",
        "created_at": "2023-07-02T11:20:59.000000Z",
        "updated_at": "2023-07-02T11:20:59.000000Z",
        "items": [
            {
                "id": 17,
                "model": "error",
                "type": "a",
                "description": "Vero consequatur accusantium labore voluptatem possimus.",
                "created_at": "2023-07-02T11:21:02.000000Z",
                "updated_at": "2023-07-02T11:21:02.000000Z"
            }
        ]
    }
}
```

### POST - Save Bike
To create a new bike, the elements must exist in the database (30 elements have been created).
Only created item IDs can be submitted.

`localhost:8080/api/bikes`

***Body:***
```json
{
  "name": "Test 3",
  "manufacturer": "ABC Bikes",
  "description": "A high-quality mountain bike",
  "price": 100.99,
  "item_ids": [10,13,21]
}
```

***Response example:***
```json
{
    "status": true,
    "data": {
        "name": "Test 3",
        "description": "A high-quality mountain bike",
        "price": 100.99,
        "manufacturer": "ABC Bikes",
        "updated_at": "2023-07-02T17:35:13.000000Z",
        "created_at": "2023-07-02T17:35:13.000000Z",
        "id": 25,
        "items": [
            {
                "id": 10,
                "model": "provident",
                "type": "et",
                "description": "Eligendi alias facilis molestias et qui sunt nihil.",
                "created_at": "2023-07-02T11:21:01.000000Z",
                "updated_at": "2023-07-02T11:21:01.000000Z"
            },
            {
                "id": 13,
                "model": "quis",
                "type": "eligendi",
                "description": "Saepe atque est dolores voluptas numquam sed.",
                "created_at": "2023-07-02T11:21:02.000000Z",
                "updated_at": "2023-07-02T11:21:02.000000Z"
            },
            {
                "id": 21,
                "model": "repellat",
                "type": "qui",
                "description": "Ut soluta sunt autem porro voluptates adipisci.",
                "created_at": "2023-07-02T11:21:03.000000Z",
                "updated_at": "2023-07-02T11:21:03.000000Z"
            }
        ]
    }
}
```

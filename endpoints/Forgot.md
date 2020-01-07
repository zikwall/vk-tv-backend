**URL** : `/vktv/auth/forgot/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "[valid email]"
}
```

**Data example**

```json
{
	"username": "dj-on-ik@mail.ru"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "code": 200,
    "response": {
        "code": 1004,
        "message": "Instructions with further instructions were sent to the indicated email address. All the best for you!"
    }
}
```

## Error Responses

**Condition** : If 'email' not found.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 7,
    "message": "This email not found in Play database.",
    "attributes": [
        "email"
    ]
}
```

**Condition** : If 'email' is wrong.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 2,
    "message": "Invalid email adress.",
    "attributes": [
        "email"
    ]
}
```

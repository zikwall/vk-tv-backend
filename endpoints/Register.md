**URL** : `/vktv/auth/signup/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
	"username": "[unique user name]",
	"email": "[unique user email address]",
	"password": "[password in plain text]"
}
```

**Data example**

```json
{
	"username": "uniqueusername",
	"email": "aka.new@playhub.com",
	"password": "InTheDark211"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "code": 200,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ5aWktcmVzdC1qd3QiLCJpYXQiOjE1Nzg0MTI0OTUsInVpZCI6MiwiZXhwIjoxNTc4NDE0Mjk1fQ.NTjMnmfOzFjwh9dR-wNPO2rNvlBWdnDQzmPYZ8INsag",
    "token_expired": 1578414295,
    "user": {
        "id": 2,
        "username": "uniqueusername",
        "email": "aka.new@playhub.com",
        "profile": {
            "name": null,
            "public_email": null,
            "avatar": null
        }
    }
}
```

## Error Responses

**Condition** : If 'email' already use.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 3,
    "message": "This email already use.",
    "attributes": [
        "email"
    ]
}
```

**Condition** : If 'username' already use.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 4,
    "message": "This username already use.",
    "attributes": [
        "username"
    ]
}
```

**Condition** : If 'password' is wrong.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 5,
    "message": "Password may contain minimum eight characters, at least one uppercase letter, one lowercase letter and one number.",
    "attributes": [
        "password"
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

**Condition** : If 'username' is wrong.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 5,
    "message": "Username may contain next characters minimum five characters, at least uppercase letter, lowercase letter and number.",
    "attributes": [
        "username"
    ]
}
```

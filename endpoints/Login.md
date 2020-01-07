Used to collect a Token for a registered User.

**URL** : `/vktv/auth/signin/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "username": "[valid username]",
    "password": "[password in plain text]"
}
```

**Data example**

```json
{
	"username": "zikwall",
	"password": "123456"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "code": 200,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ5aWktcmVzdC1qd3QiLCJpYXQiOjE1Nzg0MTIzMjEsInVpZCI6MSwiZXhwIjoxNTc4NDE0MTIxfQ.eofYqDsH9mOombjWjRBrCvJdPwB1TuCSQYhfFXgI6m8",
    "token_expired": 1578414121,
    "user": {
        "id": 1,
        "username": "zikwall",
        "email": "dj-on-ik@mail.ru",
        "profile": {
            "name": "Andrey",
            "public_email": "dj-on-ik@mail.ru",
            "avatar": null
        }
    }
}
```

## Error Response

**Condition** : If 'username' and 'password' combination is wrong.

**Code** : `400 BAD REQUEST`

**Content** :

```json
{
    "code": 1,
    "message": "Wrong username or password.",
    "attributes": [
        "username",
        "password"
    ]
}
```

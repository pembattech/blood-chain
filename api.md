### **User Registration**

**Endpoint:**

```
POST /register
```

**Description:**
Register a new user in the Blood Chain system. Users can have roles such as `donor` or `recipient`.


**Request Body (JSON):**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "1234567890",
    "role": "donor"
}
```

**Response Example (Success):**

```json
{
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "donor",
        "phone": "1234567890"
    }
}
```

**Response Example (Error):**

```json
{
    "message": "The email has already been taken.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```
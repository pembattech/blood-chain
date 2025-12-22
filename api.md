### **User Registration**

**Endpoint:**

```
POST api/v1/register
```

**Description:**
Register a new user in the Blood Chain system. Users can have roles such as `donor` or `recipient`.


**Request Body (JSON):**

```json
{
     "name": "Ram Thakur",
  "email": "ram@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "9876543210",
  "role": "donor",
  "blood_type": "A+"
}
```

**Response Example (Success):**

```json
{
    "status": "success",
    "user": {
        "name": "Ram Thakur",
        "email": "ram@example.com",
        "phone": "9876543210",
        "blood_type": "A+",
        "role": "donor",
        "updated_at": "2025-12-22T17:05:24.000000Z",
        "created_at": "2025-12-22T17:05:24.000000Z",
        "id": 2
    },
    "token": "1|N1Jr4b7LgfPPGVdYV7jZbtWb6qn4DRcyb5EJFf2rcc885545"
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

---

## 🩸 **Donor API Documentation**


## 🔹 **Create Donor Profile**

**Endpoint:**

```
POST api/v1/donors
```

**Description:**
Create a donor profile for the authenticated user.
Each user can have **only one donor profile**.

---

### **Request Body (JSON):**

```json
{
  "location_lat": 27.7172,
  "location_lng": 85.3240,
  "last_donation_date": "2025-10-15",
  "available": true,
  "health_condition": "No major health issues"
}
```

---

### **Response Example (Success):**

```json
{
  "data": {
    "id": 1,
    "user_id": 2,
    "location_lat": "27.71720000",
    "location_lng": "85.32400000",
    "last_donation_date": "2025-10-15",
    "available": true,
    "health_condition": "No major health issues",
    "created_at": "2025-12-22T17:30:10.000000Z",
    "updated_at": "2025-12-22T17:30:10.000000Z",
    "user": {
      "id": 2,
      "name": "Ram Thakur",
      "email": "ram@example.com",
      "blood_type": "A+",
      "phone": "9876543210"
    }
  }
}
```

---

### **Response Example (Error – Validation):**

```json
{
  "message": "The location lat field is required.",
  "errors": {
    "location_lat": [
      "The location lat field is required."
    ]
  }
}
```

---

## 🔹 **Get All Donors**

**Endpoint:**

```
GET api/v1/donors
```

**Description:**
Retrieve a paginated list of donors with user details.

---

### **Response Example (Success):**

```json
{
  "data": [
    {
      "id": 1,
      "location_lat": "27.71720000",
      "location_lng": "85.32400000",
      "available": true,
      "user": {
        "name": "Ram Thakur",
        "blood_type": "A+"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 10
  }
}
```

---

## 🔹 **Get Single Donor**

**Endpoint:**

```
GET api/v1/donors/{id}
```

**Description:**
Retrieve detailed information of a specific donor.

---

### **Response Example (Success):**

```json
{
  "data": {
    "id": 1,
    "location_lat": "27.71720000",
    "location_lng": "85.32400000",
    "last_donation_date": "2025-10-15",
    "available": true,
    "health_condition": "No major health issues",
    "user": {
      "name": "Ram Thakur",
      "blood_type": "A+",
      "phone": "9876543210"
    }
  }
}
```

---

## 🔹 **Update Donor Profile**

**Endpoint:**

```
PUT api/v1/donors/{id}
```

**Description:**
Update donor availability, location, or health information.

---

### **Request Body (JSON):**

```json
{
  "available": false,
  "health_condition": "Recovered from flu"
}
```

---

### **Response Example (Success):**

```json
{
  "data": {
    "id": 1,
    "available": false,
    "health_condition": "Recovered from flu",
    "updated_at": "2025-12-22T18:10:45.000000Z"
  }
}
```

---

## 🔹 **Delete Donor Profile**

**Endpoint:**

```
DELETE api/v1/donors/{id}
```

**Description:**
Delete a donor profile permanently.

---

### **Response Example (Success):**

```json
{
  "message": "Donor deleted successfully."
}
```

---

## 🔐 **Authorization Rules**

* Only **authenticated users** can create donor profiles
* Users can **update/delete only their own donor profile**
* Admin can manage all donors (if implemented)

---

## ✅ **Donor Table Fields Summary**

| Field              | Type    | Description    |
| ------------------ | ------- | -------------- |
| user_id            | FK      | Linked user    |
| location_lat       | Decimal | Latitude       |
| location_lng       | Decimal | Longitude      |
| last_donation_date | Date    | Last donation  |
| available          | Boolean | Availability   |
| health_condition   | Text    | Optional notes |


---

# 🩸 **Blood Request API Documentation**

## 🔹 **Create Blood Request**

**Endpoint**

```
POST api/v1/blood-requests
```

**Description**
Create a new blood request by a recipient. The request includes blood type, urgency, and location.

---

### **Request Body (JSON)**

```json
{
  "recipient_id": 3,
  "blood_type_needed": "O+",
  "urgency": "high",
  "location_lat": 27.7172,
  "location_lng": 85.3240
}
```

> 🔒 `status` is automatically set to **pending**

---

### **Response Example (Success)**

```json
{
  "data": {
    "id": 5,
    "recipient_id": 3,
    "blood_type_needed": "O+",
    "urgency": "high",
    "location_lat": "27.71720000",
    "location_lng": "85.32400000",
    "status": "pending",
    "created_at": "2025-12-22T18:20:10.000000Z",
    "updated_at": "2025-12-22T18:20:10.000000Z"
  }
}
```

---

### **Response Example (Validation Error)**

```json
{
  "message": "The blood type needed field is required.",
  "errors": {
    "blood_type_needed": [
      "The blood type needed field is required."
    ]
  }
}
```

---

## 🔹 **Get All Blood Requests**

**Endpoint**

```
GET api/v1/blood-requests
```

**Description**
Retrieve a paginated list of all blood requests sorted by latest.

---

### **Response Example (Success)**

```json
{
  "data": [
    {
      "id": 5,
      "blood_type_needed": "O+",
      "urgency": "high",
      "status": "pending",
      "location_lat": "27.71720000",
      "location_lng": "85.32400000"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 12
  }
}
```

---

## 🔹 **Get Single Blood Request**

**Endpoint**

```
GET api/v1/blood-requests/{id}
```

**Description**
Retrieve details of a specific blood request.

---

### **Response Example (Success)**

```json
{
  "data": {
    "id": 5,
    "recipient_id": 3,
    "blood_type_needed": "O+",
    "urgency": "high",
    "status": "pending",
    "location_lat": "27.71720000",
    "location_lng": "85.32400000",
    "created_at": "2025-12-22T18:20:10.000000Z"
  }
}
```

---

## 🔹 **Update Blood Request**

**Endpoint**

```
PUT api/v1/blood-requests/{id}
```

**Description**
Update urgency, status, or location of a blood request.

---

### **Request Body (JSON)**

```json
{
  "urgency": "medium",
  "status": "accepted"
}
```

---

### **Response Example (Success)**

```json
{
  "data": {
    "id": 5,
    "urgency": "medium",
    "status": "accepted",
    "updated_at": "2025-12-22T18:40:12.000000Z"
  }
}
```

---

## 🔹 **Delete Blood Request**

**Endpoint**

```
DELETE api/v1/blood-requests/{id}
```

**Description**
Delete a blood request permanently.

---

### **Response Example (Success)**

```json
{
  "message": "Blood request deleted successfully."
}
```

---

## 🔐 **Authorization Rules**

| Action         | Allowed                 |
| -------------- | ----------------------- |
| Create request | Recipient               |
| Update request | Request owner / Admin   |
| Delete request | Request owner / Admin   |
| View requests  | All authenticated users |

---
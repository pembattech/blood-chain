# **Blood Chain**

## **1. Project Overview**

* **Project Name:** Blood Chain
* **Full Title:** *Blood Chain: An Automated Donor–Recipient Matching System*
* **Project Type:** Academic / BCA Final Year Project
* **System Nature:** API-based blood donation management system
* **Core Goal:**
  To automate blood donor–recipient matching and notifications using a centralized, real-time system.

---

## **2. Problem Statement**

* Manual blood donation systems are slow and unreliable.
* Lack of instant communication between donors and recipients.
* No centralized system for donor availability and blood compatibility.
* Emergency blood requests often fail due to delays.

---

## **3. System Architecture**

### **Architecture Type**

* **Three-Tier Architecture**

### **Layers**

1. **Presentation Layer**

   * Web or mobile clients
   * Built using HTML, CSS, JavaScript
   * Communicates only via APIs

2. **Application Layer**

   * Laravel (PHP framework)
   * Business logic:

     * Authentication
     * Blood matching
     * Notifications
     * Request handling

3. **Database Layer**

   * MySQL
   * Stores all system data

---

## **4. Technology Stack**

* **Backend:** Laravel (PHP)
* **Database:** MySQL
* **API Style:** RESTful APIs
* **Frontend (Clients):** HTML, CSS, JavaScript
* **Authentication:** Laravel Auth / API tokens
* **Notifications:** Laravel Notification System
* **Architecture Style:** API-first design

---

## **5. Users / Actors**

* **Donor**

  * Registers
  * Updates blood group, location, availability
  * Receives notifications
* **Recipient**

  * Submits blood requests
  * Tracks request status
* **Admin**

  * Monitors system activity
  * Manages users and requests

---

## **6. Core Functionalities**

* User registration and login
* Donor profile management
* Blood request submission
* Automated donor–recipient matching
* Blood compatibility checking
* Location-based donor filtering
* Real-time notifications
* Donation tracking
* Admin monitoring

---

## **7. Functional Requirements**

* Register donors and recipients
* Create and manage blood requests
* Match donors using blood compatibility rules
* Send notifications automatically
* Track donation status
* Maintain centralized data storage

---

## **8. Non-Functional Requirements**

* **Performance:** Real-time matching and alerts
* **Security:** Secure authentication and API access
* **Scalability:** Support increasing users and requests
* **Usability:** Simple and intuitive interaction
* **Maintainability:** Modular Laravel MVC structure

---

## **9. Blood Compatibility Rules**

* **O−:** Universal donor
* **O+:** O+, A+, B+, AB+
* **A−:** A−, A+, AB−, AB+
* **A+:** A+, AB+
* **B−:** B−, B+, AB−, AB+
* **B+:** B+, AB+
* **AB−:** AB−, AB+
* **AB+:** AB+ only

---

## **11. Database Tables (Key)**

* `users`
* `donors`
* `blood_requests`
* `blood_donations`
* `notifications`

---

## **12. Blood Matching Sequence (Logic Flow)**

1. Recipient submits blood request
2. System validates request
3. Compatible donors identified
4. Location and availability filtering
5. Notifications sent
6. Donor responds
7. Request status updated
8. Donation recorded

---

## **13. Limitations**

* Requires internet access
* Depends on accurate donor availability
* Notification delivery may vary by medium

---

## **14. Future Enhancements**

* [ ] Mobile application integration
* [ ] GPS-based distance calculation
* [ ] SMS/WhatsApp notifications
* [ ] AI-based donor prioritization
* [ ] Blood bank integration
* [ ] Analytics dashboard

---

## **15. Ideal Use Cases**

* Emergency blood requests
* Hospital coordination
* Community blood donation campaigns
* Disaster response systems

---

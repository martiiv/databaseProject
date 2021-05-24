<h1>Deployment guide:</h1>

This is the readMe for the database project for the course IDATG2204, this readme contains information about deployment as well as some test cases and endpoints. 
**For the full Endpoint documentation see the Endpoint Documentation document in the doc folder**
For a detailed description of the project see the project report found on Inspera. 

<h3>Comments about submission:</h3>

**Use software like postman to make API requests**

<h2>Local deployment guide</h2>

1. Download git repo
2. Configure .htaccess file (located in *xampp/htdocs/*) with the following data:

```bash
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule dbproject-33/(.*)$ dbproject-33/v0.1/api.php?request=$1 [QSA,NC,L]
```

3. Setup PHPStorm: settings -> Build Execution Deployment -> Deployment -> + -> localhost -> 

    Connection:

    - Folder: Path to *xampp/htdocs/*
    - Web server URL: http://localhost

    Mappings:

    - Deployment path: `dbproject-33/v0.1`
    - Web path: `/dbproject-33`

    Excluded Paths: Exclude local paths; tests, doc and vendor folders.

4. Start XAMPP: Apache + MySQL

5. Import database with the test data from `dbproject-33\doc\physical_database\testData.sql`

6. Configure dbCredentials.php (copy-paste dbCredentialsTemplate.php and rename) with *DB_NAME*, *DB_USER* and *DB_PWD*.

7. Right click root directory -> Deployment -> Upload to localhost 

8. Configure Postman with authorization cookie: 

    1. I assume that you have now created a request and is ready to send it to the API. Under the send button, click on "Cookies".
    2. Input the domain that you are using to access the API (probably localhost or 127.0.0.1), and press "Add".
    3. "Add cookie". Modify the cookie name and value, `Cookie_3=value;` -> `auth_token=EENV2yeVpGZCT8eCKxWh19fz9SZ4bA1Wh19GGkoQd4T8bHYtALHoQB6f82qqMxoh;`
    4. Do not modify anything else, just save!

9. Call endpoints in postman  (**see examples below**)

<h2>Test data:</h2>

**When testing order placement please use the following ski models:**
 - Active
 - Active Pro
 - Endurance
 - Intrasonic
 - Race Pro
 - Race Speed
 - Redline 

**Existing order numbers:** 
 - 12478
 - 19324
 - 46029 
 - 15231 
 - 15232

**Existing customer numbers:** 
- 1
- 2 
- 3 

**Endpoint cases:**

**GET:** http://localhost/dbproject-33/customer/order/

**GET:** http://localhost/dbproject-33/customer/order/2

**GET:** http://localhost/dbproject-33/customer/order/2/12478

**POST:** http://localhost/dbproject-33/customer/order/place/2/24

Json body:    
 ```
{
    "Active": 2,
    "Intrasonic": 1,
    "Endurance" : 5,
    "Race Pro" : 4
}
 ```

**PUT:** http://localhost/dbproject-33/storekeeper/order/update/15232/status/ready/

**DELETE:** http://localhost/dbproject-33/customer/order/cancel/2/15232


<h2>Functionality:</h2>

**To create an order send a POST request to this endpoint with *ski_model* and *amount*** 

**http://localhost/dbproject-33/customer/order/place/{:customer_id}/{:order_no}** , Please provide the following **JSON** body:
    

 ```
{
    "Active": 2,
    "Intrasonic": 1,
    "Endurance" : 5,
    "Race Pro" : 4
}
 ```

**To get orders in the database send a GET request to the following endpoint:**

**http://localhost/dbproject-33/customer/order/** For all orders

**http://localhost/dbproject-33/customer/order/{:customer_id}** For all orders for a costumer

**http://localhost/dbproject-33/customer/order/{:customer_id}/{:order_no}** For a specific order     

**To update the status of an order to ready send a PUT request to this endpoint(ready is the only acceptable status on this endpoint):**

**http://localhost/dbproject-33/storekeeper/order/update/{:customer_id}/status/{:status}/** 

**To delete an order send a DELETE request to this endpoint:**

**http://localhost/dbproject-33/customer/order/cancel/{:customer_id}/{:order_no}**

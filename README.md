<h1>Project Databases and Database systems</h1>

This is the main project of the Database course

<h1>Deployment guide for peer review:</h1>

<h3>Comments about submission:</h3>

**The tester has to set up their own test server to test api endpoint functionality see deployment guide**

**Use software like postman to make API requests**

**When placing orders, the tester will have to pass in order number(this number will be auto generated in the future), please do not create several orders with the same order number when testing** 

This projects functions and tests have been heavily influenced by the rest api sample project provided by the course 

Codeception tests are unstable and might not work  

<h2>Deployment guide</h2>

1. Download git repo
2. Configure .htaccess file
3. Setup deployment: PHPStorm: settings -> Build Execution Deployment -> Deployment -> + -> localhost -> 
    - local path: path to repo, 
    - deployment path: path before endpoint (localhost/api/v.01), 
    - webPath: api
4. Right click root directory -> Deployment -> Upload to localhost 
5. Call endpoints in postman   

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

**GET:** http://localhost/customer/order/

**GET:** http://localhost/customer/order/2

**GET:** http://localhost/customer/order/2/12478

**POST:** http://localhost/customer/order/place/2/24

Json body:    
 ```
{
    "Active": 2,
    "Intrasonic": 1,
    "Endurance" : 5,
    "Race Pro" : 4
}
``` 

**PUT:** http://localhost/api/storekeeper/order/update/15232/status/ready/

**DELETE:** http://localhost/customer/order/cancel/2/15232


<h2>Functionality:</h2>

**To create an order send a POST request to this endpoint:** 

**http://localhost/customer/order/place/{:customer_id}/{:order_no}** , Please provide the following **Json** body:
    
 ```
{
    "ski_model" : amount,
    "Active": 2,
    "Intrasonic": 1,
    "Endurance" : 5,
    "Race Pro" : 4
}
``` 

**To get orders in the database send a GET request to the following endpoint:**

**http://localhost/customer/order/** For all orders

**http://localhost/customer/order/{:customer_id}** For all orders for a costumer

**http://localhost/customer/order/{:customer_id}/{:order_no}** For a specific order     
    
**To update the status of an order to ready send a PUT request to this endpoint(ready is the only acceptable status on this endpoint):**

**http://localhost/api/storekeeper/order/update/{:customer_id}/status/{:status}/** 

**To delete an order send a DELETE request to this endpoint:**

**http://localhost/customer/order/cancel/{:customer_id}/{:order_no}**

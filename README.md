## Project Databases and Database systems

This is the main project of the Database course

<h1>Deployment guide for peer review:</h1>

<h3>Comments about submission:</h3>

**The tester has to set up their own test server to test api endpoint functionality**

This projects functions and tests have been heavily influenced by the rest api sample project provided by the course 

When testing order placement please use the following ski models:
 - Active
 - Active Pro
 - Endurance
 - Intrasonic
 - Race Pro
 - Race Speed
 - Redline

Codeception tests are unstable and might not work  

<h3>Functionality:</h3>

**To create an order send a POST request to this endpoint:** 

**http://localhost/customer/order/place/{:customer_id}** , Please provide the following body:
    
 ```
{
    "ski_model" : amount,
    "Active": 2,
    "Intrasonic": 1,
    "Endurance" : 5,
    "Race Pro" : 4
}
``` 

**To get all orders in the database send a GET request to the following endpoint:**

**http://localhost/customer/order/{:customer_id}/{:order_no}** (if no customer_id and order_no is provided the endpoint will list all orders)    
    
**To update the status of an order to ready send a PUT request to this endpoint(ready is the only acceptable status on this endpoint):**

**http://localhost/api/storekeeper/order/update/{:customer_id}/status/{:status}/** 

**To delete an order send a DELETE request to this endpoint:**

**http://localhost/customer/order/cancel/{:customer_id}/{:order_no}**

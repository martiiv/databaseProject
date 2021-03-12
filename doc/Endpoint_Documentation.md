# Endpoint Documentation

| Endpoints           | Methods                        | Description                                                  |
| ------------------- | ------------------------------ | ------------------------------------------------------------ |
| company/rep         | GET, POST, <br />PUT           | This resource offer functionality for the customer representative to update orders.<br />Media type: application/json |
| company/storekeeper | GET, PUT                       | This resource offer functionality for the storekeeper to manage skis (update orders)<br />Media type: application/json |
| company/planner     | POST                           | This resource uploads production plans<br />Media type: unknown |
| customer            | GET, PUT, <br />POST, (DELETE) | This resource offer functionality for the customer to create, update and manage orders. <br />Media type: application/json |
| transporter         | GET, PUT                       | This resource offer functionality for the transporter to manage shipments<br />Media type: application/json |
| public              | GET                            | This resource offer functionality for the public to gather information about various types of skis<br />Media type: application/json |

<br />
<br />


| Endpoint            | URI                                                          | Description                                                  |
| ------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| company/rep         | http://127.0.0.1/company/rep/{order_no}<br />http://127.0.0.1/company/rep/{order_state} | Use this endpoint to get information about a specific order or all orders with a given state. |
| company/storekeeper | http://127.0.0.1/company/storekeeper/<br />http://127.0.0.1/company/storekeeper/{product_id}<br />http://127.0.0.1/company/storekeeper/{order_no} | Use this endpoint to get all the orders where skis are available, add information about a specific product and update order when its ready to be shipped. |
| company/planner     | http://127.0.0.1/companyplanner                              | Use this endpoint to upload production plan for a given four-week period. |
| customer            | http://127.0.0.1/customer/ {customer_id}/order/<br />http://127.0.0.1/customer/ {customer_id}/order/{order_no}<br />http://127.0.0.1/customer/ {customer_id}/order/{order_no}/split<br />http://127.0.0.1/customer/plan | Use this endpoint to <br /><ul><li>list your orders</li><li>retrieve information about a specific order</li><li>to place an order</li><li>to cancel an order</li><li>request an order split</li><li>retrieve production plan</li></ul> |
| transporter         | http://127.0.0.1/transporter<br />http://127.0.0.1/transporter/{shipment_id} | Use this endpoint to get all the orders ready to be shipped and change the status of a specific shipment. |
| public              | http://127.0.0.1/public<br />http://127.0.0.1/public?model-name={model_name} | Use this endpoint to get information about all the skis stored in the database. It may be sorted based on model name. |

<br />
<br />



| Resource            | Representation                                               |
| ------------------- | ------------------------------------------------------------ |
| company/rep         | {"order_ no": "integer", "ski_type":  "string", "total_price": "integer", "status": "string"}<br />[orders*] |
| company/storekeeper | [orders*]<br />{"model": "string", "ski_type": "string", "temperature": "string", "grip_system": "string", "size": "integer", "weight_class": "string", "description": "string", "historical": "string", "photo_url": "string", "retail_price": "integer", "production_date": "string"} |
| company/planner     | {TBD}                                                        |
| customer            | {TBD}                                                        |
| transporter         | {TBD}                                                        |
| public              | {TBD}                                                        |


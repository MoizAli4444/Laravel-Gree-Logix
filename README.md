I made the following changes:

- Remove customer_email from the Order model as it does not exist, so do not add it in the migration. 
- Add user_id to the Merchant model and include it in the migration, but it is missing from the model. 

- Retrieve the following values from the form and validate them: `order_id`, `subtotal_price`, `merchant_domain`,  `discount_code`, `customer_email`, and `customer_name`. Pass the validated data to the WebhookController to process the order. In the controller, check if a record with the same `order_id` exists. Then, store the values in the `merchants`, `affiliates`, and `orders` tables according to the database schema and model fillable attributes.  

- After storing the data, create a page with `from_date` and `to_date` fields to return `orders`, `commission_owed`, and `revenue`. Additionally, create a view for displaying the `affiliate_email`.  

- Set up routes for storing the form fields and retrieving results within the selected date range. 
## How to run the application
- Clone or unzip the repository
- Change directory from a terminal and run `cd path/ofThe/Repository/Folder`
- Rename the `.env.example` file to `.env`
- Run `php artisan key:generate` to generate an app key
- Run composer install
- Run php artisan migrate
- Start the server: `php artisan serve`
- Here are the curls to run each route

## API Routes

### 1. Create Order
```bash
curl -X POST http://127.0.0.1:8000/api/orders \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": "user_123",
    "items": [{"name": "Product 1", "quantity": 2, "price": 10.50}],
    "total_amount": 21.00,
    "currency": "USD",
    "status": "pending",
    "payment_transaction_id": "txn_initial"
  }'
```


```

### 2. Process Payment
```bash
curl -X POST http://127.0.0.1:8000/api/orders/{order_id}/pay \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

**Example:**
```bash
curl -X POST http://127.0.0.1:8000/api/orders/order_68bc8c04ef3d4/pay \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```



### 3. Fulfill Order
```bash
curl -X POST http://127.0.0.1:8000/api/orders/{order_id}/fulfill \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

**Example:**
```bash
curl -X POST http://127.0.0.1:8000/api/orders/order_68bc8c04ef3d4/fulfill \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```


```

### 4. Cancel Order
```bash
curl -X POST http://127.0.0.1:8000/api/orders/{order_id}/cancel \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

**Example:**
```bash
curl -X POST http://127.0.0.1:8000/api/orders/order_68bc8c17f2091/cancel \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

## Error Responses

### Order Not Found (404)
```json
{
  "error": "Order not found"
}
```

### Validation Errors (422)
```json
{
  "message": "The user id field is required. (and 5 more errors)",
  "errors": {
    "user_id": ["The user id field is required."],
    "items": ["The items field is required."],
    "total_amount": ["The total amount field must be a number."],
    "currency": ["The currency field is required."],
    "status": ["The status field is required."],
    "payment_transaction_id": ["The payment transaction id field is required."]
  }
}
```

### Business Logic Error (Fulfill Unpaid Order)
```json
{
  "success": false,
  "tracking_id": "txn_initial_3",
  "failure_reason": "Order is not paid",
  "status": "pending"
}
```

## Complete Workflow Example

```bash
# 1. Create an order
ORDER_RESPONSE=$(curl -s -X POST http://127.0.0.1:8000/api/orders \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "user_id": "user_123",
    "items": [{"name": "Product 1", "quantity": 2, "price": 10.50}],
    "total_amount": 21.00,
    "currency": "USD",
    "status": "pending",
    "payment_transaction_id": "txn_initial"
  }')

# Extract order ID (requires jq)
ORDER_ID=$(echo $ORDER_RESPONSE | jq -r '.order_id')

# 2. Process payment
curl -X POST http://127.0.0.1:8000/api/orders/$ORDER_ID/pay \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"

# 3. Fulfill order
curl -X POST http://127.0.0.1:8000/api/orders/$ORDER_ID/fulfill \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

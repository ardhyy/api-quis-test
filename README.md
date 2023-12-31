# database

migration and seeder database

# authentication

If you want to access the token using a parameter query, use the URL below:

```
http://127.0.0.1:8000/api/products?key=example-key
```

or if you want to access the key token using the header please add the header with the key: X-Api-Key example as below

```
X-Api-Key : example-key
```

# inventory endpoint

Get Inventories

```
URL: /api/inventories
Method: GET
```

Get Inventory by ID

```
URL: /api/inventories/{id}
Method: GET
```

Create Inventory

```
URL: /api/inventories
Method: POST
```

Update Inventory

```
URL: /api/inventories/{id}
Method: POST
```

Delete Inventory

```
URL: /api/inventories/{id}
Method: DELETE
```

# products endpoint

Get Products

```
URL: /api/products
Method: GET
```

Get Product by ID

```
URL: /api/products/{id}
Method: GET
```

Create Product

```
URL: /api/products
Method: POST
```

Update Product

```
URL: /api/products/{id}
Method: POST
```

Delete Product

```
URL: /api/products/{id}
Method: DELETE
```

# payment method endpoint

Get Payment Method

```
URL: /api/payment-method
Method: GET
```

Get Payment Method by ID

```
URL: /api/payment-method/{id}
Method: GET
```

Create Payment Method

```
URL: /api/payment-method
Method: POST
```

Update Payment Method

```
URL: /api/payment-method/{id}
Method: POST
```

Delete Payment Method

```
URL: /api/payment-method/{id}
Method: DELETE
```

# sales endpoint

Get Sales

```
URL: /api/sales
Method: GET
```

Get Sale by ID

```
URL: /api/sales/{id}
Method: GET
```

Create Sale

```
URL: /api/sales
Method: POST
```

# example post data

Example input data Products

```
{
    "name": "Chocolate Lava Cake",
    "desc": "Decadent chocolate lava cake with a gooey center",
    "price": 60000,
    "variants": [
        {"name": "classic", "additional_price": 0},
        {"name": "vanilla ice cream", "additional_price": 15000},
        {"name": "caramel drizzle", "additional_price": 10000}
    ]
}
```

Example input data Sales

```
{
    "payment": "shopee",
    "cart": [
        {
            "product_id": 2,
            "price": 50000,
            "variants": ["chicken"]
        },
        {
            "product_id": 7,
            "price": 60000
        }
    ]
}
```

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

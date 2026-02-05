# Order Analytics – PHP Interview Assignment

## Overview
This project is a simple order analytics solution built in PHP.
It processes orders from a CSV file and outputs structured analytics in JSON format,
including total revenue and the best-selling SKU.

The solution emphasizes clean code, modularity, error handling, and reusability.

---

## Features

- Parse CSV files
- Calculate total revenue
- Identify best-selling SKU
- JSON output (API-ready)
- Error handling for missing/invalid data

---

## Tech Stack

- PHP 8+
- CSV file handling
- JSON output format

---

## Project Structure

Allsome-Order-Analytics/
├── order_analytics.php
├── allsome_interview_test_orders.csv
└── README.md

---

## Setup Instructions

1. Install PHP (XAMPP recommended for Windows)
2. Place the project folder anywhere on your computer
3. Open VS Code or terminal inside the project folder

---

## How to Run (CLI)

```bash
php order_analytics.php
```

### Example Output

```json
{
    "total_revenue": 610.00,
    "best_selling_sku": {
        "sku": "SKU-A123",
        "total_quantity": 5
    }
}
```
---

## How to Run (Browser / API)

Copy the project folder into:

C:\xampp\htdocs\

Open in browser:

http://localhost/allsome-interview-test/order_analytics.php

Note: Browser may display JSON in one line; formatting is preserved in developer tools or network inspection.

---

## Error Handling
- Handles missing CSV file
- Skips invalid or malformed rows
- Validates numeric fields
- Tracks and skips malformed rows (row numbers can be logged internally for debugging)

---

## Notes

- Logic is modular and reusable
- Can be extended to:
   - Load data from a database
   - Expose analytics via RESTful API
   - Designed with modularity, readability, and extensibility in mind.


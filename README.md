# MiniShop - CLI Product Catalog System

A command-line product catalog management application built with Pure PHP (8.2+) using Object-Oriented Programming (OOP) principles, strict type checking, and JSON file persistence without any external frameworks or databases.

# Overview

MiniShop CLI Product Catalog is designed to help store owners manage their inventory directly from the terminal. It supports multiple product types, flexible discount rules, strict business validation, automatic operation logging, and persistent JSON storage that preserves data across sessions.

# Features

- # Five Core Catalog Operations:
  1. Add Product: Add a new Physical or Digital product to the catalog.
  2. List Products: Display all products in formatted, human-readable terminal cards showing original price, applied discount, final price after discount, and shipping cost.
  3. Find Product: Retrieve a single product using its unique ID.
  4. Update Product: Modify existing product details, pricing, discount, stock, weight, or download URL.
  5. Delete Product: Remove a product permanently from the catalog.
- # Product Types (Inheritance & Polymorphism):
  - Physical Products: Have stock quantity and weight in grams, calculate shipping fees based on weight, and prevent selling quantities greater than available stock.
  - Digital Products: Always available in stock, have zero shipping fees, and require a valid download URL.
- # Discount System (Composition & Interfaces):
  - Percentage Discount: Applies a percentage off between 1% and 70%.
  - Fixed Discount: Deducts a fixed dollar amount without exceeding the product price.
  - No Discount: Keeps the original product price unchanged.
- # Business Rules & Encapsulation:
  - All class properties are `private` and protected against invalid external modification.
  - Product price must be greater than zero.
  - Product name cannot be empty or shorter than 3 characters.
  - Stock quantity cannot drop below zero.
  - Product IDs are strictly unique across the catalog.
  - Digital product download links must be valid URLs.
- # Fault-Tolerant JSON Persistence:
  - Saves all catalog data in a single `products.json` file.
  - Safely handles missing, empty, or corrupted JSON files on startup without crashing.
- # Reusable Operation Logging (`Trait`):
  - Logs every `ADD`, `UPDATE`, and `DELETE` operation with its exact timestamp in `operations.log`.

# Technical Requirements

- PHP 8.2 or higher.
- Strict types enabled (`declare(strict_types=1);`) across all files.
- Complete parameter and return type hints.

# How to Run

1. Start the interactive CLI application:
   `php index.php`

2. Follow the on-screen menu options:
   - Enter `1` to add a new product (Physical or Digital).
   - Enter `2` to view all products in the catalog.
   - Enter `3` to search for a product by its ID.
   - Enter `4` to update an existing product.
   - Enter `5` to delete a product by its ID.
   - Enter `6` to sell stock from a physical product.
   - Enter `0` to save and exit the program.
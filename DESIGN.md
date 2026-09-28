# 1. What classes did you create and why?
- `Product` (Abstract Class): Groups shared properties across all products (id, name, price, category, createdAt, discount) and enforces common business rules in a single place to prevent code duplication.
- `PhysicalProduct` & `DigitalProduct`: Represent concrete product types; each class encapsulates its own specific data and behavior (stock quantity, weight, and weight-based shipping for physical products; download URL and free shipping for digital products).
- `DiscountInterface` with `NoDiscount`, `PercentageDiscount`, and `FixedDiscount`: Separates discount calculation logic into independent classes following the Single Responsibility Principle and Polymorphism instead of cluttering the product class with `if/else` conditions.
- `StorageInterface` & `JsonStorage`: Decouples disk read/write operations from the catalog management logic.
- `ProductCatalog`: Manages the five core CRUD operations (add, list, find, update, delete) and guarantees product `ID` uniqueness.
- `Logger` (Trait): Provides horizontal, reusable timestamped operation logging that can be attached to any future class in the system.

# ==================================================================================================================================

## 2. Where did you use inheritance, where did you avoid it, and why?
- Used Inheritance (`extends`) between `Product` and its child classes (`PhysicalProduct` and `DigitalProduct`) because they share an `"Is-A" relationship`: a physical product is a product, and a digital product is a product, sharing the same core structure.

- Avoided Inheritance for `Discounts`, `Storage`, and `Logging`, using `Composition ("Has-A")`, `Interfaces`, and a `Trait` instead:
  - A product has a discount (`Has-A Discount`) rather than being a type of discount, allowing its discount type to be changed dynamically at runtime.
  - The catalog has a storage engine (`Has-A StorageInterface`).
  - Logging (`Logger`) is implemented as a `Trait` because future classes (such as orders or invoices) do not share an inheritance hierarchy with the catalog but still require the same logging capability.

# ==================================================================================================================================

# 3. How would you add the third product type (Supplier On-Demand Products)? Which files would you touch?
`FIRST :` Create one new file: `src/Products/SupplierOrderProduct.php` extending `Product`, defining its specific properties and its custom shipping calculation.
`SECOND :` Minor update in `src/Catalog/ProductCatalog.php`: Add a branch in `reconstructProduct()`  to handle the `'supplier'` type.
`THIRD :` Minor update in `index.php`: Add option `3` to the product creation menu in the terminal.

# ==================================================================================================================================

# 4. How would you switch storage from JSON to a Database? Which files would change?
`FIRST :` Create one new file: `src/Storage/DatabaseStorage.php` implementing `StorageInterface` (`implements StorageInterface`) with `loadAll()` and `saveAll()` methods.
`SECOND :` Change a single line in `index.php`: Replace `new JsonStorage(...)` with `new DatabaseStorage(...)` and pass it to `new ProductCatalog($storage)`.

# ==================================================================================================================================

# 5. Which Magic Methods did you use, what problem did they solve, and what was the alternative?
In addition to `__construct`, I used two magic methods:
`FIRST :` `__toString()` in `Product` and the discount classes:
   - Problem Solved: Allowed objects to be printed directly in the terminal via `echo \(product;` while automatically embedding the formatted discount description (`"Discount: " .\)this->discount`).
   - Alternative without it: Writing a regular method such as `$product->formatAsText()` and calling it manually every time a product or discount is displayed.
`SECOND :` `__invoke()` in the discount classes (`DiscountInterface`):
   - Problem Solved: Allowed treating the discount object as a callable function `\(discount(\)price)` that validates discount compatibility with the price and returns the final discounted price in one step.
   - Alternative without it: Defining a standard method inside the interface such as `\(discount->calculateDiscountedPrice(\)price)`.

# ==================================================================================================================================

# 1. PHP Built-in Functions

| Name | Where Used | What It Does | Source |=================================================================================================================================
| `date` | `Logger.php` & `Product.php` -->
| Formats current date and time as a string | https://www.php.net/manual/en/function.date.php |
# =================================================================================================================================
| `file_put_contents` | `Logger.php` & `JsonStorage.php` -->
| Writes text data directly to a file | https://www.php.net/manual/en/function.file-put-contents.php |
# =================================================================================================================================
| `round` | `PercentageDiscount.php` & `FixedDiscount.php` & `Product.php` & `PhysicalProduct.php` -->
| Rounds a float number to 2 decimal places | https://www.php.net/manual/en/function.round.php |
# =================================================================================================================================
| `trim` | `Product.php` & `DigitalProduct.php` & `JsonStorage.php` & `ProductCatalog.php` & `index.php` -->
| Removes whitespace from both ends of a string | https://www.php.net/manual/en/function.trim.php |
# =================================================================================================================================
| `strlen` | `Product.php` -->
| Returns the length of a string| https://www.php.net/manual/en/function.strlen.php |
# =================================================================================================================================
| `array_merge` | `PhysicalProduct.php` & `DigitalProduct.php` -->
| Combines two or more arrays into one single array | https://www.php.net/manual/en/function.array-merge.php |
# =================================================================================================================================
| `filter_var` | `DigitalProduct.php` -->
| Checks and validates a variable using a specific filter | https://www.php.net/manual/en/function.filter-var.php |
# =================================================================================================================================
| `file_exists` | `JsonStorage.php` -->
| Checks if a file exists on disk | https://www.php.net/manual/en/function.file-exists.php |
# =================================================================================================================================
| `file_get_contents` | `JsonStorage.php` -->
| Reads the entire content of a file from disk and returns string | https://www.php.net/manual/en/function.file-get-contents.php |
# =================================================================================================================================
| `json_decode` | `JsonStorage.php` -->
| Converts a JSON string into a PHP array | https://www.php.net/manual/en/function.json-decode.php |
# =================================================================================================================================
| `is_array` | `JsonStorage.php` & `ProductCatalog.php`  -->
| Checks if a variable is an array | https://www.php.net/manual/en/function.is-array.php |
# =================================================================================================================================
| `json_encode` | In `JsonStorage.php` inside the `saveAll` method -->
| Converts a PHP structure into a JSON string | https://www.php.net/manual/en/function.json-encode.php |
# =================================================================================================================================
| `array_key_exists` | `ProductCatalog.php`  -->
| Checks if a specific key already exists inside an array | https://www.php.net/manual/en/function.array-key-exists.php |
# =================================================================================================================================
| `count` | `ProductCatalog.php`-->
| Counts all elements in an array | https://www.php.net/manual/en/function.count.php |
# =================================================================================================================================
| `strtolower` | `ProductCatalog.php` & `index.php`  -->
|Converts a string to lowercase | https://www.php.net/manual/en/function.strtolower.php |
# =================================================================================================================================
| `fgets` | `index.php`  -->
| Reads a full line of text typed by the user in the terminal | https://www.php.net/manual/en/function.fgets.php |
# =================================================================================================================================
| `is_numeric` | `index.php`  -->
| Checks if a value is a valid number | https://www.php.net/manual/en/function.is-numeric.php |
# =================================================================================================================================
| `unset` | `ProductCatalog.php` -->
| Completely removes a specific element from the array using its key | https://www.php.net/manual/en/function.unset.php |
# =================================================================================================================================
| `isset` | `ProductCatalog.php` -->
| Checks if a variable is set and not null | https://www.php.net/manual/en/function.isset.php |
# -----------------------------------------------------------------------------------------------------------------------------------
# 2. PHP Magic Methods
 
| Function Name | Where It Was Used | What It Does | Official Documentation Source |
# =================================================================================================================================
| `__invoke` | `DiscountInterface.php` & `FixedDiscount.php` & `NoDiscount.php` & `PercentageDiscount.php` -->
| Calls discount object like  function to calculate final price |https://www.php.net/manual/en/language.oop5.magic.php#object.invoke|
# =================================================================================================================================
| `__toString` | `Product.php` & `DiscountInterface.php` & `FixedDiscount.php` & `NoDiscount.php` & `PercentageDiscount.php` -->
| Converts the object into a formatted string when printed | https://www.php.net/manual/en/language.oop5.magic.php#object.tostring |
# -----------------------------------------------------------------------------------------------------------------------------------

# Following PSR Standards

| File Type | File Name  |
|-----------|------------|
| Class     | PascalCase |
| Handler   | PascalCase |
| View      | snake_case |
| Config    | snake_case |

| Type          | Convention  | Example                            |
|---------------|-------------|------------------------------------|
| Variable      | 	userName   | camelCase, descriptive             |
| Constant      | 	MAX_USERS  | UPPERCASE, underscores             |
| Loop Counter	 | i, j	       | Single letter for short loops only |

## Class

Class names MUST be declared in StudlyCaps.

Class constants MUST be declared in all upper case with underscore separators.

Method names MUST be declared in camelCase.

## Tags

PHP code MUST use the long <?php ?> tags or the short-echo <?= ?> tags

## Method and Function Arguments

In the argument list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.

Method and function arguments with default values MUST go at the end of the argument list.

```php 
<?php

class ClassName
{
    public function foo(int $arg1, &$arg2, $arg3 = [])
    {
        // method body
    }
}
```

# Class database fetch
All class methods should return an `associative array` after performing database quaries
PDO result object name should be `stmt`

# Naming Class Objects
Use camelCase

    Start with a lowercase letter, capitalize each subsequent word.

    Example: $userProfile, $orderManager, $dbConnection

Descriptive and Contextual

    The variable name should clearly indicate the purpose or type of the object.

    Example: If your class is Invoice, use $invoice or $customerInvoice as the variable name.

Singular Form

    Since an object represents a single instance, use the singular form.

    Example: $user for a User class, not $users.

# Handling Dynamic actions

Actions that include dynamicity such as ( e.g. increment item qty in cart)
data should be handled by AJAX first. [ID, QTY, Action] (by onclick, onchange events)
Then, data should be sent to handler by POST request, generated from AJAX.
Then any db actions should be done in class only.

### Why this ?
No Reloading / Refresh of page, improves user experience.

# Handler Requests
Every request made using AJAX, needs to have `request` key set,
it will be used to perform action based on that.
E.g. 
```php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $productId = $_POST['productId'];
    $cartQty = (int)$_POST['cartQty'];
    $request = $_POST['request']; // Must have this

    switch ($request) {
        case 'decrementQty':
        case 'incrementQty':
        {
            if ($cart->setQuantity($productId, $cartQty)) {
```
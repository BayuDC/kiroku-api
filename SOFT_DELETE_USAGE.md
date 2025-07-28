# Soft Delete Usage Guide

This guide explains how to use the soft delete functionality that has been implemented for the `users`, `categories`, `tools`, and `consumables` tables.

## What is Soft Delete?

Soft delete allows you to "delete" records without actually removing them from the database. Instead, a `deleted_at` timestamp is set, and Laravel automatically excludes these records from normal queries.

## Models with Soft Delete

The following models now support soft deletes:
- `User`
- `Category`
- `Tool`
- `Consumable`

## Basic Usage

### Soft Deleting Records

```php
// Soft delete a user
$user = User::find(1);
$user->delete(); // Sets deleted_at timestamp

// Soft delete using query
User::where('role', 'staff')->delete();

// Force delete (permanently remove from database)
$user->forceDelete();
```

### Querying Records

```php
// Get only non-deleted records (default behavior)
$users = User::all();

// Get only soft-deleted records
$deletedUsers = User::onlyTrashed()->get();

// Get all records including soft-deleted ones
$allUsers = User::withTrashed()->get();
```

### Restoring Soft-Deleted Records

```php
// Restore a single record
$user = User::onlyTrashed()->find(1);
$user->restore();

// Restore multiple records
User::onlyTrashed()->where('role', 'staff')->restore();
```

### Checking Soft Delete Status

```php
$user = User::withTrashed()->find(1);

// Check if record is soft-deleted
if ($user->trashed()) {
    echo "User is soft-deleted";
}
```

## Relationship Handling

### Categories with Tools/Consumables

When working with relationships involving soft-deleted records:

```php
$category = Category::find(1);

// Get only active tools
$activeTools = $category->tools;

// Get all tools including soft-deleted ones
$allTools = $category->toolsWithTrashed;

// Same for consumables
$activeConsumables = $category->consumables;
$allConsumables = $category->consumablesWithTrashed;
```

### Tools/Consumables with Categories

```php
$tool = Tool::withTrashed()->find(1);

// This will work even if the category is soft-deleted
// because we use withTrashed() in the relationship
$category = $tool->category;
```

## Important Notes

1. **Foreign Key Constraints**: The foreign key constraints have been updated to use `restrict` instead of `cascade` to prevent accidental data loss when trying to delete categories that have associated tools or consumables.

2. **Related Records**: When you soft-delete a category, the associated tools and consumables are NOT automatically soft-deleted. You need to handle this manually if desired:

```php
$category = Category::find(1);

// Soft delete all related tools and consumables first
$category->tools()->delete();
$category->consumables()->delete();

// Then soft delete the category
$category->delete();
```

3. **API Responses**: By default, soft-deleted records won't appear in API responses unless explicitly requested with `withTrashed()`.

## Examples in Controllers

```php
// UserController example
class UserController extends Controller 
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->get('include_deleted')) {
            $query->withTrashed();
        }
        
        if ($request->get('only_deleted')) {
            $query->onlyTrashed();
        }
        
        return $query->get();
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete
        
        return response()->json(['message' => 'User deleted successfully']);
    }
    
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        
        return response()->json(['message' => 'User restored successfully']);
    }
    
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete(); // Permanent delete
        
        return response()->json(['message' => 'User permanently deleted']);
    }
}
```

## Database Schema

Each table now has a `deleted_at` column:
- `users.deleted_at`
- `categories.deleted_at`
- `tools.deleted_at`
- `consumables.deleted_at`

These columns are `NULL` for active records and contain a timestamp for soft-deleted records.

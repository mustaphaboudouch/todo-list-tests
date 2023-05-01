# TodoList Tests

## Run project

If you want to run the project on your own, please follow these steps :

1. Clone the Project (`git@github.com:mustaphaboudouch/todo-list-tests.git`)
2. Move to the project folder (`cd todo-list-tests`)
3. Install PHP dependencies (`composer install`)
4. Install & build JS dependencies (`npm install && npm run build`)
5. Migrate database (`php artisan migrate:refresh`)
6. Run server (`php artisan serve`)
7. Let's go : <a href="http://127.0.0.1:8000">http://127.0.0.1:8000</a>

## Run tests

1. Run the command (`php artisan test`)

## Files structure

### Entities

1. User : `app/Models/User.php`
2. TodoList : `app/Models/TodoList.php`
3. Item : `app/Models/Item.php`

### Functionalities

1. UserController : `app/Http/Controllers/UserController.php`
2. ItemController : `app/Http/Controllers/ItemController.php`

### Tests

1. UserTest : `tests/Feature/UserTest.php`
2. TodListTest : `tests/Feature/TodoListTest.php`
3. ItemTest : `tests/Feature/ItemTest.php`

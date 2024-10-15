<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="Faker/db_seeder.php">
        <div>
            <span>
                Addresses amount
            </span>
            <input type="number" min="0" name="addresses_amount">
        </div>
        <div>
            <span>
                Users amount
            </span>
            <input type="number" min="0" name="users_amount">
        </div>
        <div>
            <span>
                Categories amount
            </span>
            <input type="number" min="0" name="categories_amount">
        </div>
        <div>
            <span>
                Posts amount
            </span>
            <input type="number" min="0" name="posts_amount">
        </div>
        <button type="submit" class="btn btn-primary">Seed</button>
    </form>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header class="h-10 w-7/12 px-5 mx-auto flex items-center gap-10 bg-slate-400">
        <div class="w-4/12"></div>
        <div class="w-8/12 flex justify-center items-center gap-5">
            <div class="flex gap-5">
                <a href="/movies" class="hover:text-slate-100">Movies</a>
                <?php if(!isset($_SESSION['user'])):  ?>
                <a href="/user/login" class="hover:text-slate-100">Login</a>
                <?php endif ?>
                <a href="/profile" class="hover:text-slate-100">Profile</a>
            </div>
            <?php if(isset($_SESSION['user'])):  ?>
            <div class="flex ml-10 gap-5">
                <span class="block font-semibold text-slate-900 cursor-pointer"><?php echo $_SESSION['user'] ?></span>
                <a href="/user/logout" class="block hover:text-slate-100">Exit</a>
            </div>
            <?php endif ?>
        </div>
    </header>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
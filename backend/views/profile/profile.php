<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="w-7/12 flex mx-auto mt-5 h-screen bg-slate-100">
        <div class="w-10/12 p-5">
            <h1 class="text-2xl text-slate-600">
                Welcome, <span class="font-semibold"><?php echo $_SESSION['name'] ?></span>
            </h1>
            <h1 class="mt-10 text-xl text-slate-600 font-medium">
                My favorite movies:
            </h1>
            <div class="flex gap-5 mt-3">
                <?php foreach($moviesList as $value): ?>
                <a href="/movies/<?php echo $value['movies_id'] ?>">
                    <div class="w-20">
                        <img src="<?php echo 'https://image.tmdb.org/t/p/w500' . $value['poster_path'] ?>" class="w-20"
                            alt="" />
                        <h2 class="text-sm mt-1 text-slate-600 font-semibold break-normal">
                            <?php echo $value['title'] ?>
                        </h2>
                    </div>
                </a>
                <?php endforeach ?>
            </div>
        </div>
        <div class="w-2/12 p-5 flex h-16 text-slate-800 justify-end">
            <a href="/user/logout">
                <button @click="getLogout()" class="w-16 bg-slate-400">Exit</button>
            </a>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="w-7/12 mt-5 mx-auto bg-slate-100">
        <div class="flex justify-end pl-5 pr-5 pt-5">
            <div class="w-3/12">
                <img src="<?php echo 'https://image.tmdb.org/t/p/w500' . $movieItem['poster_path']  ?>" alt="img"
                    class="w-60 mt-7" />
            </div>
            <div class="w-9/12">
                <div class="flex justify-end">
                    <?php if($favorit): ?>
                    <form action="/favorit/remove" method="POST">
                        <input type="hidden" name="id" value="<?php echo $movieItem['id'] ?>">
                        <button class="text-4xl text-yellow-400">&#9733;</button>
                    </form>
                    <?php else: ?>
                    <form action="/favorit/add" method="POST">
                        <input type="hidden" name="id" value="<?php echo $movieItem['id'] ?>">
                        <button class="text-4xl text-yellow-400">&#9734;</button>
                    </form>
                    <?php endif ?>
                    <!-- <button @click="addToFavorite" class="text-4xl text-yellow-400">
                        {{ isFavorite ? "&#9733;" : "&#9734;" }}
                    &#9734;
                    add
                    </button> -->
                </div>
                <h1 class="text-xl font-semibold ml-36 mb-2">
                    <?php echo $movieItem['title'] ?>
                </h1>
                <div class="">
                    <span class="w-32 font-semibold text-lg inline-flex">Дата выхода:
                    </span>
                    <span class="text-lg"><?php echo $movieItem['release_date'] ?></span>
                </div>
                <div>
                    <span class="w-32 font-semibold text-lg inline-flex">Жанры:
                    </span>
                    <span class="text-lg">
                        <?php foreach($movieItem['categories'] as $category) :?>
                        <?php echo $category ?>
                        <?php endforeach ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h1 class="font-semibold">
                Про что фильм: <?php echo $movieItem['title'] ?>
            </h1>
            <p class="description">
                <?php echo $movieItem['overview'] ?>
            </p>
        </div>
        <div class="mx-auto">
            <div class="p-5">
                <iframe class="w-full h-[720px]" src="https://www.youtube.com/batman"></iframe>
            </div>
        </div>
    </div>


</body>

</html>
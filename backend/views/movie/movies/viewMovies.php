<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
</head>

<body>

    <div class="w-7/12 h-20 flex mx-auto">
        <div class="w-6/12 flex items-center bg-slate-200">
            <form method="GET" class="p-5 flex">
                <input name="search" type="text" class="w-64 text-slate-700" placeholder="Search" />
                <button formmethod="GET" type="submit"
                    class="flex justify-center items-center bg-slate-300 opacity-60 w-8">
                    <img src="../../../assets/img/free-icon-search-6368029.png" class="h-5 opacity-60" alt="" />
                </button>
            </form>
        </div>
        <div class="w-6/12 flex justify-end items-center pr-5 bg-slate-200">
            <div class="flex flex-col">
                <form method="GET">
                    <select name="select">
                        <option value="" class="bg-slate-300">All movies</option>
                        <?php foreach($categories as $category) :?>
                        <option value="<?php echo $category['name']; ?>"
                            <?php echo isset($_GET['select']) && $_GET['select'] === $category['name'] ? 'class=bg-blue-600' : '' ?>
                            <?php echo isset($_GET['select']) && $_GET['select'] === $category['name'] ? 'selected' : '' ?>>
                            <?php echo $category['name']; ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                    <button formmethod="get" type="submit" class="w-20 bg-slate-100">Выбрать</button>
                </form>
            </div>
        </div>
    </div>
    <div class="w-7/12 mt-5 mx-auto  p-5  bg-slate-200">
        <div class="flex flex-wrap gap-7 pb-5">
            <?php if($errors): ?>
            <h2 class="text-slate-600 text-xl"><?php echo $errors ?></h2>
            <?php endif ?>
            <?php foreach($moviesList as $value) :?>
            <div class="w-60 bg-white cursor-pointer">
                <a href="<?php echo '/movies/' . $value['id'] ?>">
                    <div>
                        <img src="<?php echo 'https://image.tmdb.org/t/p/w500' . $value['poster_path'] ?>" alt="" />
                    </div>
                    <div class="px-1">
                        <h3 class="h-8 pt-1 text-center text-xs font-semibold text-slate-600 my-0 mx-auto">
                            <?php echo $value['title']; ?>
                        </h3>
                        <span v-for="(item, index) in movie.genre_ids" :key="index"
                            class="inline text-xs text-slate-600">
                            <?php foreach($value['categories'] as $category) :?>
                            <?php echo $category ?>
                            <?php endforeach ?>
                        </span>
                    </div>
                    <div class="relative flex px-1">
                        <p class="text-xs text-slate-500  ">
                            <?php echo $value['release_date']; ?>
                        </p>
                    </div>
                </a>
            </div>
            <?php endforeach ?>
        </div>

    </div>
    <div class="w-7/12 mx-auto mb-10 pb-5 flex justify-center bg-slate-200">
        <?php echo $pagination->get() ?>
    </div>

</body>

</html>
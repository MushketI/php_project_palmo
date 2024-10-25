<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="w-7/12 mx-auto pt-28 h-screen">
        <form method="POST">
            <div class="w-96 h-64 p-2 mx-auto bg-slate-100">
                <h2 class="font-semibold text-slate-700">Login</h2>
                <?php if(isset($errors) && is_array($errors)): ?>
                <div class="text-red-600 font-semibold">
                    <?php foreach($errors as $error): ?>
                    <p><?php echo $error ?></p>
                    <?php endforeach ?>
                </div>
                <?php endif ?>
                <div class="flex flex-col py-2">
                    <label for="email" class="text-slate-700">Email</label>
                    <input v-model="email" type="email" name="email" placeholder="Your email"
                        value="<?php echo $email ?>"
                        class="border-2 border-slate-200 focus:border-slate-500 text-slate-700" />
                </div>
                <div class="flex flex-col">
                    <label for="password" class="text-slate-700">Password</label>
                    <input v-model="password" type="password" name="password" placeholder="Password"
                        value="<?php echo $password ?>"
                        class="border-2 border-slate-200 focus:border-slate-500 text-slate-700" />
                </div>
                <div class="pt-4">
                    <input type="submit" name="login" class="w-full bg-slate-600 text-slate-200"></input>
                </div>
                <div class="pt-2">
                    <span class="text-slate-500 text-sm">Are you not registered yet?
                        <a href="/user/register" class="text-slate-700">Sing up</a>
                    </span>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
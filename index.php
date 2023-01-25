<?php
include_once('./launch.php');

$page = $_GET['page'] ?? 'home';

if (!file_exists('./static/pages/' . $page . '.uploader.php')) {
    $page = 'image';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader.PRO - Free File Hosting</title>
    <meta name="title" content="Uploader.PRO - Free File Hosting">
    <meta name="description" content="Uploader pro description">
    <meta name="robots" content="index, follow, upload, file, file upload">
    <meta http-equiv="content-language" content="en">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.47.0/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js"></script>
</head>

<body>
    <div class="drawer drawer-end">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content">
            <?php include_once('./static/include/navbar.uploader.php'); ?>
            <div class="min-h-[45.5vh]">
                <?php include_once('./static/pages/' . $page . '.uploader.php'); ?>
            </div>
            <?php include_once('./static/include/footer.uploader.php'); ?>
        </div>


    </div>

    <div class="drawer-side">
        <label for="my-drawer" class="drawer-overlay"></label>
        <ul class="menu p-4 w-80 bg-[#030207] text-white">
            <div class="flex justify-between items-center border-b border-zinc-400/30 pb-3 mb-6">
                <h1 class="text-xl font-medium">Sayfa Bağlantıları</h1>
                <label for="my-drawer"
                    class="p-2 flex items-center justify-center hover:bg-zinc-400/10 rounded-md cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12m0 -12l12 12"></path>
                    </svg>
                </label>
            </div>

            <div class="flex flex-col gap-2">
                <a href="/#"
                    class="text-white/70 hover:text-white text-lg px-1 py-2 w-full hover:bg-zinc-400/10 rounded transition-all duration-200">
                    Navbar Link
                </a>
                <a href="/#"
                    class="text-white/70 hover:text-white text-lg px-1 py-2 w-full hover:bg-zinc-400/10 rounded transition-all duration-200">
                    Navbar Link
                </a>
                <a href="/#"
                    class="text-white/70 hover:text-white text-lg px-1 py-2 w-full hover:bg-zinc-400/10 rounded transition-all duration-200">
                    Navbar Link
                </a>
                <a href="/#"
                    class="text-white/70 hover:text-white text-lg px-1 py-2 w-full hover:bg-zinc-400/10 rounded transition-all duration-200">
                    Navbar Link
                </a>
            </div>

        </ul>
    </div>
</body>

<script> /* Navbar javascript */
    let navbarBtn = document.getElementById("navbarBtn")
    if (navbarBtn) {
        navbarBtn.addEventListener("click", (event) => {
            let itemsList = document.getElementById("navLinks")
        })
    }
</script>

</html>
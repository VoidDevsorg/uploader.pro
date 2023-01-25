<?php
$config = json_decode(file_get_contents('./static/config.json'), true);
include_once("./functions/manager.uploader.php");

$totalImages = getTotalImagesCount();

$formattedNumber = number_format($totalImages);
?>

<div class="container">
    <div class="flex flex-col items-center text-center">
        <h1 class="text-3xl font-medium mb-3">What makes us different from other sites?</h1>
        <p class="text-zinc-400 text-sm">The files of our users are not deleted. You can upload and store up to <span class="text-white/80 hover:text-white transition-all cursor-pointer">25 MB</span> of free file.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6">
            <div class="flex flex-col gap-4">
                <img class="h-56 w-56 mx-auto" src="public/images/rocket.svg" alt="">
                <h1 class="text-2xl font-medium">Easy and Fast</h1>
                <p class="text-zinc-300 max-w-12">Select the file and upload it easy and fast with one click.</p>
            </div>
            <div class="flex flex-col gap-4">
                <img class="h-56 w-56 mx-auto" src="public/images/share.svg" alt="">
                <h1 class="text-2xl font-medium">Total share</h1>
                <p class="text-zinc-300 max-w-12">There are <span
                        class="text-white font-medium text-lg">
                        <?php echo $formattedNumber ?>
                    </span> files currently stored on our website.</p>
            </div>
            <div class="flex flex-col gap-4">
                <img class="h-56 w-56 mx-auto" src="public/images/server.svg" alt="">
                <h1 class="text-2xl font-medium">Storage</h1>
                <p class="text-zinc-300 max-w-12">Store your files for as long as you want.</p>
            </div>
        </div>
    </div>
</div>
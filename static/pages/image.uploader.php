<?php
$config = json_decode(file_get_contents('./static/config.json'), true);
include_once './functions/manager.uploader.php';

$full = $_SERVER['REQUEST_URI'];
$full = explode('/', $full);
$full = array_filter($full);

$image = getImage($full[2]);

if (!$image || $image == 0 || $image == "0") {
    return header('Location: /');
}

?>

<div class="container w-full min-h-[58vh] flex flex-col justify-center items-center mt-12">
    <div class="bg-[rgb(var(--primary))] rounded-xl shadow-xl overflow-hidden">
        <img src="<?php echo $image['download_url']; ?>" alt="image" class="flex-shrink-0">
        <div class="flex items-center justify-between p-4">
            <div>
                <p class="text-white text-left text-xl font-semibold">
                    <?php echo $image['name']; ?>
                </p>
                <span class="text-zinc-400 text-sm font-normal">Published at Unknown</span>
            </div>
            <div class="flex items-center gap-2">
                <button id="deleteButton"
                    class="relative bg-red-600/5 px-3 py-3 font-medium rounded-xl flex items-center gap-6 group">
                    <div
                        class="absolute inset-0 w-full h-full left-0 top-0 opacity-0 group-hover:opacity-10 group-active:opacity-20 transition-all duration-300 ease-in-out rounded-xl bg-red-700">
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                            clip-rule="evenodd" />
                    </svg>

                </button>

                <a href="https://i.uploader.pro/<?php echo $full[2] ?>" target="_blank"
                    class="relative bg-zinc-500/5 px-3 py-3 font-medium rounded-xl flex items-center gap-6 group">
                    <div
                        class="absolute inset-0 w-full h-full left-0 top-0 opacity-0 group-hover:opacity-10 group-active:opacity-20 transition-all duration-300 ease-in-out rounded-xl bg-white">
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd"
                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="https://i.uploader.pro/<?php echo $full[2] ?>" target="_blank"
                    class="relative bg-gradient-to-r from-blue-600 to-indigo-800 px-6 py-3 font-medium rounded-xl flex items-center gap-6 group">
                    <div
                        class="absolute inset-0 w-full h-full left-0 top-0 opacity-0 group-hover:opacity-10 group-active:opacity-20 transition-all duration-300 ease-in-out rounded-xl bg-white">
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"
                            clip-rule="evenodd" />
                    </svg>
                    Download
                </a>
            </div>
        </div>
    </div>

    <div id="deleteionArea"
        class="opacity-0 pointer-events-none -translate-y-24 transition-all duration-200 relative flex justify-between items-center w-2/4 gap-4 mt-4">
        <input id="deletionKeyInput"
            class="bg-[rgb(var(--primary))] rounded-xl w-full h-full bg-transparent outline-none inset-0 placeholder-gray-400 p-6 py-6 border border-violet-600/10 hover:border-violet-600/20 focus:border-violet-600/50 transition-all duration-200"
            placeholder="Enter your deletion key..." />

        <button onclick="deleteImage()"
            class="absolute right-4 bg-red-600/10 px-6 py-3 font-medium rounded-xl flex items-center gap-6 group">
            <div
                class="absolute inset-0 w-full h-full left-0 top-0 opacity-0 group-hover:opacity-10 group-active:opacity-20 transition-all duration-300 ease-in-out rounded-xl bg-red-700">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd"
                    d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                    clip-rule="evenodd" />
            </svg>
            Confirm
        </button>
    </div>
</div>

<script>
    function deleteImage() {
        let deletionKey = $('#deletionKeyInput').val();

        if (deletionKey == '') {
            alert('Please enter your deletion key!');
            return;
        }

        $.ajax({
            url: "./api/delete?access_token=<?php echo $_SESSION['token']; ?>&id=<?php echo $full[2]; ?>&deletionKey=" + deletionKey,
            type: "POST",
            contentType: false,
            cache: false,
            processData: false,
            enctype: 'multipart/form-data',
            success: function (data) {
                let $_data = JSON.parse(data);
                if ($_data.success) {
                    // window.location.href = './';
                } else {
                    alert("Error: " + $_data.message);
                }
            }
        });
    };

    $('#deleteButton').click(() => {
        console.log('clicked');
        let isHidden = $('#deleteionArea').hasClass('opacity-0')

        if (isHidden) {
            $('#deleteionArea').removeClass('opacity-0 pointer-events-none -translate-y-24');
            $('#deleteionArea').addClass('opacity-100 pointer-events-auto translate-y-0');
        } else {
            $('#deleteionArea').removeClass('opacity-100 pointer-events-auto translate-y-0');
            $('#deleteionArea').addClass('opacity-0 pointer-events-none -translate-y-24');
        }
    });
</script>
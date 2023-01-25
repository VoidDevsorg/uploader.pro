<div class="container w-full h-[58vh] flex flex-col justify-center items-center">
    <form id="uploadForm" action="" method="POST" enctype="multipart/form-data"
        class="relative w-full h-4/6 transition-all duration-300 hover:bg-[#06040D] rounded-xl border-2 border-dashed border-zinc-500/5 p-4 flex justify-center items-center flex-col cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12">
            <path
                d="M9.97.97a.75.75 0 011.06 0l3 3a.75.75 0 01-1.06 1.06l-1.72-1.72v3.44h-1.5V3.31L8.03 5.03a.75.75 0 01-1.06-1.06l3-3zM9.75 6.75v6a.75.75 0 001.5 0v-6h3a3 3 0 013 3v7.5a3 3 0 01-3 3h-7.5a3 3 0 01-3-3v-7.5a3 3 0 013-3h3z" />
            <path
                d="M7.151 21.75a2.999 2.999 0 002.599 1.5h7.5a3 3 0 003-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 01-4.5 4.5H7.151z" />
        </svg>

        <p class="text-center mt-2">Drag and drop your files here</p>
        <div id="preview" class="hidden absolute inset-0 w-full h-full flex flex-col justify-center items-center"></div>
        <input type="file" name="file" id="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
    </form>

    <div id="uploaded" class="hidden flex flex-col justify-center items-center mt-4">
        <p class="text-center">
            Image successfully uploaded!
        </p>

        <div class="flex items-center gap-2 mt-2">
            <a id="viewImage"
                class="text-center text-[#F9A8D4] hover:text-[#F472B6] transition-all duration-200 cursor-pointer">
                View image
            </a>

            <a onclick="revealKey()"
                class="text-center text-[#F9A8D4] hover:text-[#F472B6] transition-all duration-200 cursor-pointer">
                Reveal Deletion Key
            </a>
        </div>

        <input readonly type="text"
            class="mt-1 bg-black/50 px-4 py-3 w-full rounded-xl outline-none ring-none border border-violet-500/10 focus:border-violet-500/50 transition-all duration-200 hidden"
            id="imageLink">
    </div>
</div>

<?php include_once './static/include/features.uploader.php'; ?>

<script>
    function revealKey() {
        let key = document.getElementById("imageLink");
        key.classList.remove("hidden");
        key.select();
        key.setSelectionRange(0, 99999);
        document.execCommand("copy");
    }


    $("#file").change(postImage);

    function postImage() {
        if (!$("#file")[0].files?.[0]) return;
        $("#uploadForm").addClass("pointer-events-none", "opacity-50");
        $.ajax({
            url: "./api/upload?access_token=<?php echo $_SESSION['token']; ?>",
            type: "POST",
            data: new FormData($("#uploadForm")[0]),
            contentType: false,
            cache: false,
            processData: false,
            enctype: 'multipart/form-data',
            success: function (data) {
                let $_data = JSON.parse(data);
                if ($_data.success) {
                    $("#uploaded").removeClass("hidden");

                    $("#viewImage").attr("href", $_data.data.file_view_url);
                    $("#imageLink").val($_data.data.deletion_key);

                    $("#preview").addClass("hidden");
                    $("#file").val("");

                    $("#uploadForm").removeClass("pointer-events-none", "opacity-50");
                } else {
                    alert("Error: " + $_data.message);
                    $("#uploadForm").removeClass("pointer-events-none", "opacity-50");
                }
            },
        });
    }
</script>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class=" py-3 flex justify-center bg-stone-200">
    <div class="bg-stone-100 p-4 rounded shadow">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return csvValidate() & fileSizeValidate()" enctype="multipart/form-data">
            <h1 class="text-4xl font-serif pb-3 border-b-2 border-black mb-2">CSV Files Uploader</h1>
            <label class="flex mb-2 font-bold" for="fileToUpload">Files to Upload:</label>
            <input name="fileToUpload" id="fileToUpload" type="file" accept=".csv" required />
            <input class=" mt-3 w-full bg-blue-500 text-white hover:bg-blue-600 py-2 px-4 rounded" type="submit" value="Submit Files" name="submit">
        </form>
        <p class="mt-2 text-gray-500">Accepted file format: .csv only</p>
        <p class="mt-2 text-gray-500">Maximum file size: 50MB</p>
    </div>

</body>

<script>
    function csvValidate() {

        var pattern = /^(.+)\.(csv)$/;
        var el = document.getElementById("fileToUpload");
        if (!pattern.test(el.value)) {
            alert("Sorry, only CSV files allowed.");
        }

    }

    function fileSizeValidate() {

        const fi = document.getElementById('fileToUpload');
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                const fileSizeInMB = file / 1024;

                if (fileSizeInMB >= 50) {
                    alert("Sorry, file size must be less than 50MB.");
                }
            }
        }
    }

</script>

</html>


<?php

function alertMessage($message)
{
?>
    <script>
        alert('<?php echo $message; ?>');
    </script>
<?php
}

if (isset($_POST["submit"])) {

    $uploadOk = 1;
    $alertShown = false;

    $target_dir = "uploads/";
    $fileExtension = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . "upload." . $fileExtension;

    if ($fileExtension != "csv") {
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 52428800) {

        $uploadOk = 0;
    } else if ($uploadOk == 1) {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            if (!$alertShown) {
                alertMessage("The file has been uploaded successfully!");
                $alertShown = true;
            }
        } else {
            if (!$alertShown) {
                alertMessage("Sorry, there was an error uploading your file");
                $alertShown = true;
            }
        }
    }
}

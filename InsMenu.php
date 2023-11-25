<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="InsMenu.css">
    <title>Document</title>
</head>

<body>
<div class="sc">
    <?php
    // Handling error of back page
    header('Cache-Control: no cache'); //no cache
    session_cache_limiter('private_no_expire');
    include 'components/db_conn.php';
    include 'components/header.php';
    
    echo '<form class="form-style-9" action="' . $_SERVER["REQUEST_URI"] . '" method="post" enctype="multipart/form-data">
            <ul>
                <li>
                    <input type="text" name="dish" class="field-style field-split align-left" placeholder="Dish Name"  required/>
                    <input type="number" name="price" class="field-style field-split align-right" placeholder="Price"  required/>
                </li>
                <li>
                    <input type="text" name="ingre" class="field-style field-full align-none" placeholder="Ingredients"  required/>
                </li>
                <li>
                    <textarea name="desc" class="field-style" placeholder="Description" required></textarea>
                </li>
                <li>
                    <label>Select Image File:</label>
                    <input type="file" name="image">
                    <input type="submit" name="submit" value="Upload">
                </li>
            </ul>
        </form>';
    ?>
    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    $status = $statusMsg = '';
    if ($method == 'POST') {
        $dish = $_POST['dish'];
        $price = $_POST['price'];
        $ingre = $_POST['ingre'];
        $desc = $_POST['desc'];
        $status = 'error';
        if (!empty($_FILES["image"]["name"])) {
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'jpeg');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['image']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));

                // Insert image content into database 
                $insert = $conn->query("INSERT INTO `menu` ( `name`, `description`, `price`,`img`,`ingredient`) VALUES ( '$dish', '$desc', '$price', '$imgContent', '$ingre')");

                if ($insert) {
                    $status = 'success';
                    $statusMsg = "File uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        } else {
            $statusMsg = 'Please select an image file to upload.';
        }
    }

    // Display status message 
    echo $statusMsg;
    ?>
    </div>
</body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</html>
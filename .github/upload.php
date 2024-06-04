<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "path/to/uploaded/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a actual PDF
    if($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Run the Python conversion script
            $output_file = "path/to/output/" . basename($target_file, ".pdf") . ".txt";
            shell_exec("python pdf_to_text.py $target_file $output_file");

            // Redirect to the main page with the link to the converted file
            header("Location: index.html?converted_file=" . $output_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

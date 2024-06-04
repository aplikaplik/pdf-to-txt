<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "path/to/uploaded/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $githubToken = $_POST['githubToken'];

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

            // Configure git
            shell_exec("git config --global user.name 'github-actions'");
            shell_exec("git config --global user.email 'github-actions@github.com'");

            // Add and commit the converted file
            shell_exec("git add $output_file");
            shell_exec("git commit -m 'Add converted text file'");
            shell_exec("git push https://$githubToken:x-oauth-basic@github.com/aplikaplik/pdf-to-txt.git main");

            // Redirect to the main page with the link to the converted file
            header("Location: index.html?converted_file=" . $output_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


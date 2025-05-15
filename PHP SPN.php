<?php
// Database config
$db = new mysqli('localhost', 'username', 'password', 'spn_form');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // File upload
    $target_dir = "uploads/";
    $file_name = basename($_FILES["file_spn"]["name"]);
    $target_file = $target_dir . uniqid() . '_' . $file_name;
    
    if (move_uploaded_file($_FILES["file_spn"]["tmp_name"], $target_file)) {
        // Insert to database
        $stmt = $db->prepare("INSERT INTO submissions (
            cabang, vendor_num, vendor_site, bank_supplier, 
            nama_rekening, nomor_rekening, email_supplier, file_path
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssssss", 
            $_POST['cabang'],
            $_POST['vendor_num'],
            $_POST['vendor_site'],
            $_POST['bank_supplier'],
            $_POST['nama_rekening'],
            $_POST['nomor_rekening'],
            $_POST['email_supplier'],
            $target_file
        );
        
        if ($stmt->execute()) {
            echo "Form submitted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "File upload failed";
    }
}
?>
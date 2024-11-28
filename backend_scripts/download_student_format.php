<?php
// Define the filename for the CSV
$filename = "student_format.csv";

// Set headers to prompt the browser to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the output stream for writing the CSV
$output = fopen('php://output', 'w');

// Add headers to the CSV file
fputcsv($output, ['Email', 'School ID', 'Last Name', 'First Name']);

// Optional: Add example data (can be left empty or adjust based on your format)
fputcsv($output, ['example@example.com', '12345', 'Doe', 'John']);

// Close the file pointer
fclose($output);

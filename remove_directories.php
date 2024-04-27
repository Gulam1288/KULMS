<?php
$departments = [
    '1st' => [
        'CSE' => ['Introduction to Programming', 'Data Structures', 'Algorithms'],
        'ECE' => ['Digital Electronics', 'Signal Processing', 'Communication Systems'],
        'IT' => ['Information Technology Fundamentals', 'Web Development Basics', 'Computer Organization'],
        'CIVIL' => ['Engineering Mechanics', 'Surveying', 'Construction Materials'],
        'MECH' => ['Engineering Drawing', 'Thermodynamics', 'Mechanics of Solids'],
        'EEE' => ['Electrical Circuits', 'Electromagnetic Fields', 'Power Systems'],
    ],
    '2nd' => [
        'CSE' => ['Advanced Data Structures', 'Database Management Systems', 'Computer Networks'],
        'ECE' => ['Microprocessors and Microcontrollers', 'Embedded Systems', 'VLSI Design'],
        'IT' => ['Object-Oriented Programming', 'Database Systems', 'Network Security'],
        'CIVIL' => ['Structural Analysis', 'Geotechnical Engineering', 'Fluid Mechanics'],
        'MECH' => ['Manufacturing Processes', 'Machine Design', 'Fluid Power Engineering'],
        'EEE' => ['Power Electronics', 'Electrical Machines', 'Control Systems'],
    ],
    '3rd' => [
        'CSE' => ['Operating Systems', 'Software Engineering', 'Machine Learning'],
        'ECE' => ['Wireless Communication', 'Digital Signal Processing', 'Embedded Systems Design'],
        'IT' => ['Data Mining', 'Software Testing', 'Mobile Application Development'],
        'CIVIL' => ['Transportation Engineering', 'Environmental Engineering', 'Structural Design'],
        'MECH' => ['Heat Transfer', 'Dynamics of Machinery', 'Automobile Engineering'],
        'EEE' => ['Renewable Energy Systems', 'Power System Protection', 'Digital Control Systems'],
    ],
    '4th' => [
        'CSE' => ['Artificial Intelligence', 'Big Data Analytics', 'Cloud Computing'],
        'ECE' => ['Internet of Things', 'Image Processing', 'Robotics'],
        'IT' => ['Cloud Security', 'Information Retrieval', 'Blockchain Technology'],
        'CIVIL' => ['Construction Management', 'Earthquake Engineering', 'Remote Sensing'],
        'MECH' => ['Finite Element Analysis', 'Robotics and Automation', 'Advanced Materials'],
        'EEE' => ['Smart Grids', 'Renewable Energy Integration', 'Electric Drives'],
    ],
];


// Define the base directory
$baseDirectory = "Project/";

// Iterate over each year
foreach ($departments as $year => $yearDepartments) {
    // Iterate over each department
    foreach ($yearDepartments as $department => $courses) {
        // Construct the directory path for the department
        $directory = $baseDirectory . $year . '/' . $department . '/';
        // Check if the directory exists
        if (is_dir($directory)) {
            // Get the list of directories in the department directory
            $subDirectories = array_diff(scandir($directory), array('.', '..'));
            // Iterate over each subdirectory
            foreach ($subDirectories as $subDirectory) {
                // Check if the subdirectory is not in the list of courses for the current year and department
                if (!in_array($subDirectory, $courses)) {
                    // Remove the subdirectory
                    $subDirectoryPath = $directory . $subDirectory;
                    if (is_dir($subDirectoryPath)) {
                        // Recursively remove the directory and its contents
                        removeDirectory($subDirectoryPath);
                    }
                }
            }
        }
    }
}

// Function to recursively remove a directory and its contents
function removeDirectory($directory) {
    if (!is_dir($directory)) {
        return;
    }
    $files = array_diff(scandir($directory), array('.', '..'));
    foreach ($files as $file) {
        $path = $directory . '/' . $file;
        (is_dir($path)) ? removeDirectory($path) : unlink($path);
    }
    rmdir($directory);
}

?>
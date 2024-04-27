<?php 
session_start();

$userType = $_SESSION['u-type'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTech Courses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>

<!-- ViewerJS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.5.1/viewer.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.5.1/viewer.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: linear-gradient(rgba(0, 0, 0, 1), rgba(0, 0, 0, 1));
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        .btech {
            text-align: center;
            color: #ff7f00;
            margin-top: 100px;
            margin-bottom: 40px;
        }

        .wrapper h2 {
            color: #fff;
            margin-top: -20px;
            padding: 20px 20px 30px;
            background: #232323;
        }

        .wrapper ul {
            list-style-type: none;
            padding: 25px;
            margin-top: -20px;
            background: #333;
        }

        .course {
            cursor: pointer;
            color: #A8D2FF;
        }

        .dept {
            color: #C2C2C2;
        }

        li {
            color: #F8F8FF;
        }

        .file-list {
            display: none;
            padding-left: 20px;
        }

        .file-list.active {
            display: block;
        }

        .file-in::before {
            content: '\f15b';
            font-family: 'Font Awesome\ 5 Free'; 
            margin-right: 5px;
        }

        .no-file::before {
            content: '\f1c3';
            font-family: 'Font Awesome\ 5 Free'; 
            margin-right: 5px;
            color: #FFD1D1;
        }
        .file-list a {
            color: #C7C7FF;
            text-decoration: none;
        }

        .file-list a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            .wrapper h1 {
                font-size: 24px;
            }

            .wrapper h2 {
                font-size: 20px;
            }

            .course {
                font-size: 16px;
            }
        }

        .navbar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .footer {
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }

        .footer .box-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .footer .box {
            flex: 1;
            padding: 10px;
        }

        .footer .box h3 {
            margin-bottom: 10px;
        }

        .footer .box a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .footer .box {
                flex: none;
                width: 90%;
            }
        }

        .wrapper {
            margin: 20px 0;
            padding: 10px 0 0;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: #fff;
            backdrop-filter: blur(90px);
            background-color: rgba(0, 0, 0, 0.8);
            /* Semi-transparent background */
            z-index: 9999;
            /* Ensure it appears on top of other elements */
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            border: 2px solid skyblue;
            transform: translate(-50%, -50%);
            background-color: #867447;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 80%;
        }

        .popup-content p {
            margin-bottom: 4px;
        }

        .view-icon {
            margin-left: 10px;
            color: #00eee0;
        }

        .delete-icon {
            color: #f33300;
        }

        .file-in .download-icon {
            margin: 0 0.5rem;
            color: #fff;
        }
#fileViewer {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
    z-index: 9999;
    overflow: auto; /* Enable scrolling if content exceeds viewport */
}

.fv {
    max-width: 90%; /* Adjust maximum width as needed */
    max-height: 90vh; /* Adjust maximum height as needed */
    background-color: #fff;
    margin: 15px auto;
    padding: 0px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    overflow: auto; /* Enable scrolling within container if necessary */
}

.fw button {
    margin: 10px auto;
    padding: 10px 16px;
    width: 50%;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
</head>

<body>
    <div id="popup" class="popup">
        <div class="popup-content">
            <p>Access not allowed without login.</p>
            <p>Redirecting to login page...</p>
        </div>
    </div>

    <script>
        var userType = localStorage.getItem('u-type');

        // If userType is neither "admin" nor "users", display the popup box and redirect after a delay
        if (userType !== "admin" && userType !== "users") {
            var popup = document.getElementById('popup');
            popup.style.display = 'block';

            // Redirect after a delay
            setTimeout(function () {
                window.location.href = "login.html";
            }, 3000); // Redirect after 5 seconds (5000 milliseconds)
        }
    </script>

    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img
                    src="https://tse3.mm.bing.net/th?id=OIP.neMoV_sF2wamLIaJFhzF-AAAAA&pid=Api&P=0&h=180"
                    alt="Logo"></a></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item" id="login">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="courses.php">Courses</a>
                    </li>
                    <li class="nav-item" id="uploadAble">
                        <a class="nav-link" href="upload_files.php">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact us</a>
                    </li>
                    <li class="nav-item" id="logoutLink">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="btech">
        <h1>BTech Curriculum</h1>
    </div>

</script>
    <div class="wrapper">
        <div id="curriculum">
            <?php
            // Get the year, department, and course from the query parameters
            $year = isset($_GET['year']) ? $_GET['year'] : '';
            $department = isset($_GET['department']) ? $_GET['department'] : '';
            $course = isset($_GET['course']) ? $_GET['course'] : '';

            // List of years
            $years = ['1st', '2nd', '3rd', '4th'];

            // List of departments and their courses for each year
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

            foreach ($years as $curYear) {
                echo "<h2>$curYear Year";
                echo "<button class='btn btn-secondary float-end btn-sm' onclick='expandYear(\"$curYear\")' id='expandBtn$curYear'>Expand All</button>";
                echo "<button class='btn btn-secondary float-end btn-sm' onclick='collapseYear(\"$curYear\")' id='collapseBtn$curYear' style='display: none;'>Collapse All</button>";
                echo "</h2>";
                echo "<ul>";

                foreach ($departments[$curYear] as $curDepartment => $courses) {
                    echo "<li><strong class='dept'>$curDepartment:</strong>";
                    echo "<ul>";

                    foreach ($courses as $curCourse) {
                        echo "<li class='course' data-year='$curYear' data-department='$curDepartment' data-course='$curCourse'>$curCourse";
                        echo "<ul class='file-list'>";

                        // Construct the path to the directory containing the files
                        $directory = "Project/$curYear/$curDepartment/$curCourse/files/";

                        if (is_dir($directory)) {
                            // Get the list of files in the directory
                            $files = array_diff(scandir($directory), array('.', '..'));
                            if (count($files) > 0) {
                                foreach ($files as $file) {
    // Display file with delete icon only for admin users
    echo "<li class='file-in'>
              <a href='$directory$file'>$file</a>
              <span class='view-icon' onclick='openFileViewer(\"$directory$file\")'><i class='fas fa-eye'></i></span>
              <span class='download-icon' title='Download'><a class='download-icon' href='$directory$file' download><i class='fas fa-download'></i></a></span>";
    
    // Check if the user is admin
    if ($userType === "admin") {
        echo "<span class='delete-icon' onclick='deleteFile(\"$directory$file\")'><i class='fas fa-trash'></i></span>";
    }
    
    echo "</li>";
}
                            } else {
                                echo "<li class='no-file'>No files available</li>";
                            }
                        } else {
                            echo "<li class='no-file'>No files available</li>";
                            // Create directory for course if not present
                            mkdir($directory, 0777, true);
                        }

                        echo "</ul>";
                        echo "</li>";

                        // Create directory for course if not present
                        if (!is_dir($directory)) {
                            mkdir($directory, 0777, true);
                        }
                    }

                    echo "</ul>";
                    echo "</li>";
                }
                echo "</ul>";
            }
            ?>

        </div>
    </div>
<div id="fileViewer" class="fw">
    <center><button class="btn btn-secondary px-2" onclick="closeFileViewer()">Close</button></center>
    <div class="fv">
        <div id="fileContentContainer"></div>
    </div>

</div>

    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>More links</h3>
                <a href="#">www.kucet.com</a>
                <a href="#">www.kucet results.com</a>
                <a href="#">www.help desk.com</a>
            </div>
            <div class="box">
                <h3>Locations</h3>
                <a href="#">Telangana</a>
                <a href="#">Hanmakonda</a>
                <a href="#">Kottagudam</a>
            </div>
            <div class="box">
                <h3>Contact info</h3>
                <a href="#">+91-xxxxxxxxxx</a>
                <a href="#">abc@gmail.com</a>
                <a href="#">Hanmakonda-Telangana</a>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function expandYear(year) {
            var fileLists = document.querySelectorAll('[data-year="' + year + '"] .file-list');
            fileLists.forEach(function (fileList) {
                fileList.classList.add('active');
            });
            document.getElementById('expandBtn' + year).style.display = 'none';
            document.getElementById('collapseBtn' + year).style.display = 'block';
        }

        function collapseYear(year) {
            var fileLists = document.querySelectorAll('[data-year="' + year + '"] .file-list');
            fileLists.forEach(function (fileList) {
                fileList.classList.remove('active');
            });
            document.getElementById('expandBtn' + year).style.display = 'block';
            document.getElementById('collapseBtn' + year).style.display = 'none';
        }

        if (localStorage.getItem('u-type') !== 'admin') {
            document.getElementById("uploadAble").style.display = "none";
        }

        if (localStorage.getItem('isLoggedIn') === 'true') {
            document.getElementById("login").style.display = "none";
        } else {
            document.getElementById("logoutLink").style.display = "none";
        }

        // Add event listeners to course names to show files on click
        var courseNames = document.querySelectorAll('.course');
        courseNames.forEach(function (course) {
            course.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent the click event from bubbling up
                if (event.target.classList.contains('course')) {
                    var fileList = this.querySelector('.file-list');
                    fileList.classList.toggle('active');
                }
            });
        });
function deleteFile(filePath) {
    var confirmation = confirm("Are you sure you want to delete this file?");
    if (confirmation) {
        fetch('delete_file.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ file: filePath }),
        })
        .then(response => {
            if (response.ok) {
                // Remove the file from the UI
                var fileToDelete = document.querySelector('a[href="' + filePath + '"]').parentNode;
                fileToDelete.remove();
                window.location.href = 'courses.php';
            } else {
                // Handle error response
                console.error('Error deleting file');
            }
        })
        .catch(error => {
            console.error('Error deleting file:', error);
        });
    }
}
// Function to open the file viewer and display file content
function openFileViewer(filePath) {
    var fileExtension = filePath.split('.').pop().toLowerCase();

    if (fileExtension === 'pdf') {
        renderPDF(filePath);
    } else if (fileExtension === 'docx' || fileExtension === 'pptx') {
        renderDocument(filePath);
    } else {
        alert('Unsupported file format');
        return;
    }

    var fileViewer = document.getElementById('fileViewer');
    fileViewer.style.display = 'block';
}

// Function to render PDF file using PDF.js
function renderPDF(filePath) {
    var fileContentContainer = document.getElementById('fileContentContainer');
    fileContentContainer.innerHTML = ''; // Clear previous content

    // Load PDF file using PDF.js
    pdfjsLib.getDocument(filePath).promise.then(function(pdf) {
        var numPages = pdf.numPages;
        var pagesPromises = [];

        for (var i = 1; i <= numPages; i++) {
            pagesPromises.push(renderPDFPage(pdf, i, fileContentContainer));
        }

        Promise.all(pagesPromises).then(function() {
            // All pages rendered
            console.log('All pages rendered');
        }).catch(function(error) {
            console.error('Error rendering PDF:', error);
        });
    }).catch(function(error) {
        console.error('Error loading PDF:', error);
    });
}

// Function to render a single PDF page
function renderPDFPage(pdf, pageNumber, container) {
    return pdf.getPage(pageNumber).then(function(page) {
        var viewport = page.getViewport({ scale: 1 });
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        container.appendChild(canvas);

        // Render the page content on canvas
        return page.render({ canvasContext: context, viewport: viewport }).promise;
    });
}

// Function to close the file viewer
function closeFileViewer() {
    var fileViewer = document.getElementById('fileViewer');
    fileViewer.style.display = 'none';
}

// Function to clear file content from the viewer
function clearFileContent() {
    var fileContentContainer = document.getElementById('fileContentContainer');
    fileContentContainer.innerHTML = ''; // Clear content
}

// Function to render PDF file
        function logout() {
            window.location.href = 'logout.php';
        }

        // Attach logout function to logout link
        document.getElementById("logoutLink").addEventListener("click", logout);
    </script>
</body>

</html>
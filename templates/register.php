<?php
require_once '../config/db.php';
require_once '../models/user.php';
require_once '../models/teacher.php';
require_once '../models/student.php';
require_once '../models/admin.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "All fields are required.";
    } else {
        try {
            if (User::register($name, $username, $email, $password, $role)) {
                header('Location: login.php');
                exit();
            } else {
                echo "Failed to register user.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="../assets/art.png"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS Animation CDN -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body style="margin: 0;
            padding: 0;
            background-image: url('https://www.brighthorizons.com/resources/-/media/bh-new/baw-blog/laptop-from-above-800x533.ashx');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;">

<div class="flex flex-col items-center justify-between pt-0 pr-10 pb-0 pl-10 mt-28 mr-auto mb-0 ml-auto max-w-7xl xl:px-5 lg:flex-row">
    <div class="flex flex-col items-center w-full pt-5 pr-10 pb-20 pl-10 lg:pt-12 lg:flex-row">
        <div class="w-full bg-cover relative max-w-md lg:max-w-2xl lg:w-7/12">
            <div class="flex flex-col items-center justify-center w-full h-full relative lg:pr-10" data-aos="fade-right" data-aos-easing="ease-in-sine" data-aos-duration="800">
                <h1 class="text-7xl text-white italic font-bold" style="text-shadow: 8px 8px 12px rgba(0, 0, 0, 0.75);">
                    “Learning never exhausts the mind.”
                </h1>
                <p class="text-4xl text-white" style="text-shadow: 8px 8px 12px rgba(0, 0, 0, 0.75);">~Leonardo da Vinci</p>
            </div>
        </div>
        <div class="w-full mt-20 mr-0 mb-0 ml-0 relative z-10 max-w-2xl lg:mt-0 lg:w-5/12">
            <div class="flex flex-col items-start justify-start pt-10 pr-10 pb-10 pl-10 bg-white shadow-2xl rounded-xl relative z-10">

                <form method="POST" action="register.php" class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                    <!-- Name -->
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Name</p>
                        <input type="text" name="name" placeholder="Name" class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
                    </div>

                    <!-- Email -->
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Email</p>
                        <input type="email" name="email" placeholder="theshamkhi@gmail.com" class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
                    </div>

                    <!-- Username -->
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Username</p>
                        <input type="text" name="username" placeholder="Username" required class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
                    </div>

                    <!-- Role -->
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Role</p>
                        <select name="role" id="role" class="border focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md">
                            <option value="teacher" class="text-gray-600">Teacher</option>
                            <option value="student" class="text-gray-600">Student</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Password</p>
                        <input type="password" name="password" placeholder="•••••••" required class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
                    </div>

                    <div class="relative">
                        <button type="submit" class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-green-500
                        rounded-lg transition duration-200 hover:bg-green-600 ease">Register</button>
                    </div>

                    <div class="relative">
                        <p class="text-center font-medium text-gray-600">Already have an account, 
                            <a href="login.php" class="text-green-600 font-bold hover:underline">Login</a>
                        </p>
                        <p class="text-center font-medium text-gray-600">Go to 
                            <a href="visitorDashboard.php" class="text-green-600 font-bold hover:underline">Home page</a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script>
  AOS.init();
</script>

</body>
</html>
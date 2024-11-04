<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: #E2F1E7; 
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;}

.profile-container {
    background: white; 
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 400px; 
    width: 100%;}

h2 {
    text-align: center;
    color: #333; 
    margin-bottom: 20px;}

.profile-photo {
    text-align: center; 
    margin-bottom: 20px; }

.profile-img {
    width: 100px;
    height: 100px; 
    border-radius: 50%; 
    object-fit: cover; 
    border: 2px solid #ccc; }

.input-group { margin-bottom: 15px;}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;}

input[type="text"],input[type="email"],input[type="tel"],input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; }
input[type="radio"] {margin-right: 5px;}

.btn {
    width: 100%;
    padding: 10px;
    background: #387478; 
    color: white; 
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;}
.btn:hover {background: #629584;}
</style>
</head>
<body>

<div class="profile-container">
    <h2>User Profile</h2>

    <div class="profile-photo">
        <img src="<?php echo isset($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="profile-img">
    </div>

    <form action="profile.php" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="input-group">
            <label for="number">Phone Number:</label>
            <input type="tel" id="number" name="number" required>
        </div>

        <div class="input-group">
            <label for="gender">Gender:</label>
            <input type="radio" name="gender" value="M" checked> Male
            <input type="radio" name="gender" value="F"> Female
        </div>

        <div class="input-group">
            <label for="profile_photo">Profile Photo:</label>
            <input type="file" id="profile_photo" name="profile_photo">
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="update">Update Profile</button>
        </div>
    </form>
</div>

</body>
</html>

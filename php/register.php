<!DOCTYPE html>
<html>
  <s>
    <title>Registration Page</title>
<style>

body {
    margin: 0;
    padding: 0;
    font-family: Arial;
    background-color: #f4f4f4;
    height: 100vh; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
}

/* Center the container */
.container {
    max-width: 400px; 
    padding: 20px;}

/* Style the heading */
h1 {
    text-align: center;
    color: #333;
    margin: 0; }

/* Style for the form groups */
.form-group {
    margin-bottom: 15px; 
    display: flex;
    align-items: center; 
}

/* Style for labels */
label {
    flex: 1; 
    margin-right: 10px; 
    color: #555;
}

/* Style for input fields */
.form-control {
    flex: 2; 
    padding: 10px;
    border: 1px solid #ccc; 
    border-radius: 4px;
    
}

/* Style for radio buttons */
.radio-inline {
    margin-right: 10px; 
}

/* Style for submit button */
.btn {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none; 
    border-radius: 4px; 
    cursor: pointer; 
    font-size: 16px; 
}

/* Button hover effect */
.btn:hover {
    background-color: #4666; 
}


</style>

</head>
  <body>
    <div class="container">
            <h1>Registration</h1>
          </div>
         
          <div class="body">
            <form action="connect.php" method="post">
              <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName"/>
              </div>

              <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName"/>
              </div>

            <div class="form-group">
                <label for="gender">Gender</label>
            <div>
                <labe for="male" class="radio-inline">
                <input type="radio" name="gender" value="m" id="male">Male</labe>
                      
                <label for="female" class="radio-inline">
                <input type="radio"name="gender"value="f"id="female">Female</label>
            </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="phone" class="form-control" id="phone" name="phone">
            </div>

            <input type="submit" class="btn">
            </form>
          </div>
         
        </div>
      </div>
    </div>
  
  </body>
</html>

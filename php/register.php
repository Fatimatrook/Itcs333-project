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
:root{
    --first-color:#243642;
    --seconed-color: #387478;
    --third-color:#629584;
    --forth-color: #E2F1E7;
}
html{
    font-size: 62.5%;
    overflow-x: hidden;
    scroll-padding-top: 9rem;
    scroll-behavior: smooth;
}

html::-webkit-scrollbar{
    width: .8rem;
}
html::-webkit-scrollbar-track{
    background: transparent;
}
html::-webkit-scrollbar-thumb{
    background: #ffffff;
    border-radius: 5rem;
}
body{
    background: var(--forth-color);
}
section{
    padding: 2rem 7%;
}
.btn{
    margin-top: 1rem;
    display: inline-block;
    padding: .9rem 3rem;
    font-size: 1.7rem;
    color: #fff;
    background:var(--first-color) ;
    cursor: pointer;
}
.btn:hover{
    letter-spacing: .1rem;
}
.header{
    background: var(--forth-color);
    display: flex;
    align-items: center;
    justify-content: space-between ;
    padding: 1.5rem 7%;
    border-bottom: var(--first-color);
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
}
.header .logo img{
    height: 6rem;
}
.header .navbar a{
    margin:0 1rem;
    font-size: 1.6rem;
    color: var(--first-color);
}
.header .navbar a:hover{
    color: var(--seconed-color);
    border-bottom: .1rem solid var(--seconed-color);
    padding-bottom: .5rem;
}
.header .icons div{
    color: var(--first-color);
    cursor: pointer;
    font-size: 2.5rem;
    margin-left: 2rem;
}
.header .icons div:hover{
    color: var(--seconed-color);
}
#menu-btn{
    display: none;
}
.header .search-form{
    position: absolute;
    top: 115%; right: 7%;
    background: var(--forth-color);
    width: 50rem;
    height: 5rem;
    display: flex;
    align-items: center;
    transform: scaleY(0);
    transform-origin: top;
}
.header .search-form.active{
    transform: scaleY(1);

}
.header .search-form input{
    height: 100%;
    width: 100%;
    font-size: 1.6rem;
    color: #000;
    padding: 1rem;
    text-transform: none;
}
.header .search-form label{
    cursor: pointer;
    font-size: 2.2rem;
    margin-right: 1.5rem;
    color: #000;
}
.header .search-form label:hover{
  color: var(--first-color);
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
    <!--Header start-->    
    <header class="header">
        
        <!-- this is for  uob logo-->
        <a href="#" class="logo"><img src="images/UOB LOGO.png" alt="uob logo"></a>
        <!-- this is for  uob logo end-->    
        
        <!--navbar-->
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about">About us</a>
            <a href="php/login.php">Log in</a>
            <a href="#rooms">Rooms</a>
            <a href="#contact">Contact us</a>
            <a href="#reviews">Reviews</a>
        </nav>
        <!--navbar end-->
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>

        <div class="search-form">
            <input type="search" id="search-box" placeholder="search here...">
            <label for="search-box" class="fas fa-search"></label>
        </div>
    </header>
    <!--Header end-->
    
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

<!DOCTYPE html>
<html>
  <head>
    <title>VROOMCAR</title>
    <link rel="stylesheet" href="home.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    
    <!-- nav bar section -->
<section id="section0" class="header">
  <nav>
    <a href="#section0" class="logo">
      
      VROOM<span class="h1car">CAR</span>
    </a>
    <div class="navbar">
      <ul>
        <li><a href="#section0">HOME</a></li>
        <li><a href="#section1">ABOUT US</a></li>
        <li><a href="#section2">CONTACT</a></li>
        <li><a href="#section3">LOGIN</a></li>
      </ul>
    </div>
  </nav>
</section>

    
    <!-- home page -->
    <div class="text-box">
      <h2>Unlock the Power of Fleet Management with VROOMCAR</h2>
      <p>Track your vehicles in real-time, manage tasks effortlessly, and ensure proactive maintenance</h2>
      <p>Streamline your operations with our intuitive platform</p>
      <p>Simplify your management, boost your efficiency.</p>
      <a href="#section1" class="btn">Visit Us To Know More</a>
  
    
    
  </div>

    <!-- about us page-->
    <div class="about" id="section1">
      <div class="about-content">
        <img src="../img/str.png" class="img">
        <h2>ABOUT US</h2>
        <p>Welcome to VroomCar!</p>
        <p>At VroomCar, we aim to simplify vehicle fleet management efficiently and transparently. Our platform is designed for auto dealerships, car rental businesses, and automotive professionals.</p>
        <p>Our mission is to provide innovative solutions that help our clients maximize operational efficiency, optimize inventory management processes, and enhance market competitiveness. With our technological expertise and commitment to excellence, we are dedicated to delivering superior services and an exceptional customer experience.</p>
        <p>Whether you're managing a large fleet or streamlining used car sales operations, VroomCar is your trusted partner. Join us today to discover how we can simplify your fleet management and drive your business success.</p>
        <p>The VroomCar Team.</p>
      </div>
    
    <!-- contact page-->
    <div class="contact" id="section2">
      <div class="info">
        
        <h1>CONTACT US</h1>
        <p><i class="fa-solid fa-envelope"></i> Email: <a href="mailto:vroomcar@gmail.org">vroomcar@gmail.org</a></p>
        <p><i class="fa-solid fa-phone"></i> Telephone: <a href="tel:+21392686176">+213 92 68 61 76</a></p>
        <p><i class="fa-solid fa-location-dot"></i> Place: <a href="tel:+21392686176">456 Park Avenue, Springdale, CA 90210</a></p>
      </div>
      <form action="#" method="POST">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required placeholder="Enter your name">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="form-group">
          <label for="telephone">Telephone:</label>
        
          <input type="tel" id="telephone" name="telephone " placeholder="Enter your phone number">
        </div>
        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject"  placeholder="Subject">
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5"  ></textarea>
        </div>
        <button type="submit">Send</button>
      </form>
    </div>
  </div>
  <!-- login page -->
<div class="login" id="section3">
  
  <h1>LOGIN</h1>
  <form action="#" method="POST">
    <div class="form-group">
      <label for="email2">Email:</label>
      <input type="email" id="email2" name="email2" required placeholder="Enter your email">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">
    </div>
    <button type="submit">Login</button>
   
  </form>
</div>
<footer>
  <p>Copyrights © 2024 VROOMCAR</p>
</footer>
  </body>
</html>
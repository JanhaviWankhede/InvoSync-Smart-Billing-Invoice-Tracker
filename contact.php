<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: Nunito, sans-serif;
      margin: 0;
      padding: 0;
    }
    .section_10 {
      width: 100%;
      display: flex;
      justify-content: center;
      padding: 20px;
    }
    .form-container {
      max-width: 600px;
      width: 100%;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .input, .textinput {
      width: 100%;
      padding: 12px;
      border: 1px solid #e5e5e5;
      border-radius: 5px;
      font-size: 16px;
      margin-bottom: 15px;
    }
    .button-container {
      display: flex;
      justify-content: space-between;
    }
    .submit-btn, .go-back-btn {
      width: 48%;
      height: 40px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      text-align: center;
    }
    .submit-btn {
      background-color: #6c5ce7;
      color: white;
    }
    .submit-btn:hover {
      background-color: #4834d4;
    }
    .go-back-btn {
      background-color: #ccc;
      color: black;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .go-back-btn:hover {
      background-color: #bbb;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class="section_10">
    <div class="form-container">
      <form id="contact-form">
        <label>Full Name</label>
        <input class="input" id="full-name" name="FullName" placeholder="Full Name" required>
        
        <label>Email Address</label>
        <input class="input" id="email" name="Email" placeholder="Email" type="email" required>
        
        <label>Phone Number (Optional)</label>
        <input class="input" id="phone" name="Phone" placeholder="Phone Number" type="tel">
        
        <label>Preferred Contact Method</label>
        <label><input type="radio" name="contact-method" value="email" checked> Email</label>
        <label><input type="radio" name="contact-method" value="phone"> Phone</label>
        
        <label>Type of Issue</label>
        <label><input type="radio" name="issue-type" value="technical" checked> Technical</label>
        <label><input type="radio" name="issue-type" value="billing"> Billing</label>
        <label><input type="radio" name="issue-type" value="other"> Other</label>
        
        <label>Message</label>
        <textarea class="textinput" id="message" placeholder="Write a message..." required></textarea>
        
        <div class="button-container">
          <a href="index.html" class="go-back-btn">Go Back</a>
          <button class="submit-btn" id="submit-button">Send Message</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Angus & Coote</title>
    <link rel="stylesheet" href="../Style/user_login.css">
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 40px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background: #333;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form>
            <label for="name">Your Name:</label>
            <input type="text" id="name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" required>

            <label for="message">Message:</label>
            <textarea id="message" rows="5" required></textarea>

            <button type="submit" onclick="alert('Message submitted!')">Send Message</button>
        </form>
    </div>
</body>
</html>

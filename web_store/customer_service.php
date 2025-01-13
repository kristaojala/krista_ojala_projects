<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Customer Service</title>
</head>
<body>
<?php
    include "header.php";

    //Sivun tekstit sponsored by ChatGPT
    ?>
    <main>
        <div class="simple-column">
        <h1>Customer Service</h1>

<h2>Contact Information</h2>
<p>If you have any questions, concerns, or need assistance, our customer service team is here to help. You can reach us through the following channels:</p>
<ul>
  <li>Email: <a href="mailto:support@loremipsumstore.com?Subject=Customer%20Support""><b>support@loremipsumstore.com</b></a></li>
  <li>Phone: <b>1-800-123-4567</b></li>
</ul>

<h2>Business Hours</h2>
<p>Our customer service representatives are available to assist you during the following hours:</p>
<p>Monday to Friday: 9:00 AM - 6:00 PM</p>
<p>Saturday and Sunday: Closed</p>

<h2>FAQs (Frequently Asked Questions)</h2>
<p>Before reaching out to customer service, you may find answers to common questions on our <a href="faq.php"><b>FAQ page</b></a>. This page covers topics such as ordering, payments, shipping, returns, and more.</p>

<p>Thank you for choosing Lorem Ipsum. We appreciate your business and look forward to providing you with excellent customer service.</p>
        </div>
    </main>
    <?php
   include "footer.php";
   ?>
</body>
</html>
<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Lottery</title>
</head>
<body>
    <?php include "header.php";
    ?>
    <main>
<div class="title-texts">
<h1>Lux Lottery</h1>
<p>Indulge in the ultimate luxury experience by participating in our exclusive Luxury Lottery! 
Immerse yourself in the thrill of anticipation and the promise of winning extravagant prizes.</p>

<p>As you embark on this exciting journey, envision the possibilities: 
a dream vacation to exotic destinations, high-end fashion that exudes elegance, 
cutting-edge technology that enhances your lifestyle, and much more. 
Our Luxury Lottery is your gateway to a world of sophistication and indulgence.</p>

<p>How to play? It's simple! Click the "Start" button to set the wheels in motion. 
Watch as the mesmerizing animation unfolds, each ball representing a chance for you to claim a prize beyond your wildest imagination.</p>

<p>Feel the anticipation build with every spin, and when the animation concludes, discover if you're the fortunate winner of our lavish rewards. 
Whether it's a luxurious getaway, a statement piece of jewelry, or the latest in tech innovation, our Luxury Lottery promises an experience like no other.</p>

<p>Don't miss this opportunity to elevate your lifestyle. Play the Lux Lottery now and immerse yourself in the world of extravagance!</p>

</div>

<audio id="lotterySound" src="media/lottery.mp3" preload="auto"></audio>
<div class="lottery-center">
   <!-- Tää on ehkä tyhäm tapa tehdä asia,
   mutta en nyt ala säätää tämän takia.-->
   <div class="machine" id="machine">
    <div>
      <div class="ball blue"></div>
      <div class="ball red"></div>
      <div class="ball green"></div>
      <div class="ball yellow"></div>
      <div class="ball blue"></div>
      <div class="ball red"></div>
      <div class="ball green"></div>
      <div class="ball yellow"></div>
      <div class="ball blue"></div>
      <div class="ball red"></div>
      <div class="ball green"></div>
      <div class="ball yellow"></div>
    </div>
    <div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
      </div>
      <div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
      </div>
      <div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
      </div>
      <div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
      </div>
      <div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
        <div class="ball blue"></div>
        <div class="ball red"></div>
        <div class="ball green"></div>
        <div class="ball yellow"></div>
      </div>
   </div>
   <div class="overlay" id="overlay">
                <h2 id="LotteryText"></h2>
                <form id="emailForm" class="hidden" method="post" action="lottery.php">
        <input type="hidden" name="win" id="winInput" value="">
        <label for="email">Enter your email: </label>
        <input type="email" id="email" name="email" required disabled>
        <br>
        <button class="button" type="submit" disabled>Submit</button>
    </form>
                
                <button id="startButton" class="button" onclick="startAnimation()"><b>Start</b></button>
            </div>
        </div>
</main>
<?php include "footer.php"; ?>
</body>

<script>
// Kun klikkaa "start" painiketta, console antaa tämän errorin:

// lottery.php:185 Uncaught ReferenceError: startAnimation is not defined
//     at HTMLButtonElement.onclick (lottery.php:185:84)

//     se ei tunnu vaikuttavan ja en saanut sitä lähtemään ilman että koko systeemi hajoaa niin annoin olla.
//     Tekoälykään ei osannut auttaa tässä. Olkoot nyt, ei ole kuitenkaan tämän näytön asia osata JSää

document.addEventListener("DOMContentLoaded", function () {
    const machine = document.getElementById('machine');
    const balls = document.querySelectorAll('.ball');
    const overlay = document.getElementById('overlay');
    const startButton = document.getElementById('startButton');
    const lotterySound = document.getElementById('lotterySound');
    let animationInterval;
    const LotteryText = document.getElementById('LotteryText');
    let animationDone = false;
    let win = false;

    function rollBalls() {
        overlay.classList.add('hidden');
        balls.forEach(ball => {
            const randomRotation = Math.floor(Math.random() * 360);
            const randomTranslationX = Math.floor(Math.random() * 400) - 200;
            const randomTranslationY = Math.floor(Math.random() * 400) - 200;

            ball.style.transform = `translate(${randomTranslationX}px, ${randomTranslationY}px) rotate(${randomRotation}deg)`;
        });
    }

    function updateText() {
        if (animationDone) {
            startButton.classList.add('hidden');
            if (win) {
            LotteryText.innerHTML = "Congratulations!<br>You've won a special prize!<br>Please enter your email to receive a 10% discount.";
            showEmailForm();
        } else {
            LotteryText.innerHTML = "You didn't win this time.";
        }
        } else {
            startButton.classList.remove('hidden');
            LotteryText.textContent = "Play the lottery to win prizes!";
        }
    }


    function showEmailForm() {
    const emailForm = document.getElementById('emailForm');
    emailForm.classList.remove('hidden');
    startButton.classList.add('hidden');
    startButton.removeEventListener("click", startAnimation);
    startButton.disabled = true;
    const emailInput = document.getElementById('email' );
    emailInput.disabled = false;
    const submitButton = document.querySelector('#emailForm button[type="submit"]');
    submitButton.disabled = false;
}

function hideEmailForm() {
     const emailForm = document.getElementById('emailForm');
    emailForm.classList.add('hidden');
    const emailInput = document.getElementById('email') ;
    emailInput.disabled = true;
    const submitButton = document.querySelector('#emailForm button[type="submit"]');
    submitButton.disabled =  true; 
}

    function startAnimation() {
        win = true // Math.floor(Math.random() * 2) === 0; //Jotta tästä voittaa nyt todella helposti.
        console.log("Win value (JavaScript):", win);
        lotterySound.play();
        animationInterval = setInterval(() => {
            rollBalls();
        }, 500);
        startButton.classList.add('hidden');

        setTimeout(() => {
            clearInterval(animationInterval);
            overlay.classList.remove('hidden');
            animationDone = true;
            updateText();

            lotterySound.pause();
        }, 9000);

    }

    updateText();

    startButton.addEventListener("click", startAnimation);

    const emailForm = document.getElementById('emailForm');
    emailForm.addEventListener("submit", function (event) {
        event.preventDefault();
        LotteryText.innerHTML =  "Thank you for participating!<br>An email with further instructions has been sent to you.";
        //No it hasn't. Ei tähän työhön haha.
        hideEmailForm();
    });
});
</script>
</html>


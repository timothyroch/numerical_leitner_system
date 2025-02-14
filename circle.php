<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numerical Leitner System - Animated Sphere</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --background-dark: #333;
      --text-light: #ddd;
      --primary-blue: #1e90ff; /* Dodger Blue */
      --secondary-blue: #4682b4; /* Steel Blue */
      --accent-blue: #00bfff; /* Deep Sky Blue */
      --tertiary-blue: #87cefa; /* Light Sky Blue */
    }

    body {
      font-family: 'Roboto', sans-serif;
      background-color: var(--background-dark);
      color: var(--text-light);
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .header {
      margin-bottom: 2vh;
      color: var(--primary-blue);
    }

    .header h1 {
      font-size: 3rem;
      margin: 0;
    }

    .header p {
      font-size: 1.5rem;
      margin: 0.5rem 0;
    }

    .main-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 90%;
      max-width: 600px;
    }

    .sphere-wrapper {
      position: relative;
      width: 50vw; /* Responsive width */
      height: 50vw; /* Aspect ratio is 1:1 */
      max-width: 300px;
      max-height: 300px;
      perspective: 1000px; /* Perspective for the 3D effect */
    }

    .sphere {
      position: absolute;
      width: 100%;
      height: 100%;
      transform-style: preserve-3d;
      animation: rotate3d 10s linear infinite;
    }

    .plane {
      position: absolute;
      width: 100%;
      height: 100%;
      transform-style: preserve-3d;
    }

    .spoke {
      position: absolute;
      width: 0;
      height: 50%;
      transform-origin: 0 0;
      transform-style: preserve-3d;
      left: 50%;
      top: 50%;
    }

    .dot {
      position: absolute;
      width: 1vw; /* Responsive size */
      height: 1vw; /* Responsive size */
      max-width: 8px;
      max-height: 8px;
      border-radius: 50%;
      background: var(--accent-blue);
      left: -0.5vw; /* Center dot */
      top: 100%;
      transform: rotateX(90deg);
    }

    @keyframes rotate3d {
      0% { transform: rotate3d(1,1,1,0deg); }
      25% { transform: rotate3d(1,1,1,90deg); }
      50% { transform: rotate3d(1,1,1,180deg); }
      75% { transform: rotate3d(1,1,1,270deg); }
      100% { transform: rotate3d(1,1,1,360deg); }
    }

    @keyframes pulsate {
      0% { transform: rotateX(90deg) scale(.4) translateZ(30px); }
      100% { transform: rotateX(90deg) scale(1) translateZ(0px); }
    }

    .info {
      font-size: 1.5rem;
      color: var(--text-light);
      margin: 2vh 0;
    }

    .info span {
      color: var(--primary-blue);
      font-weight: 700;
    }

    .footer {
      position: absolute;
      bottom: 2vh;
      color: var(--text-light);
      font-size: 0.9rem;
      width: 90%;
      max-width: 600px;
    }

    .footer a {
      color: var(--primary-blue);
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .rotating-text {
      font-family: 'Roboto', sans-serif;
      font-weight: 600;
      font-size: 2rem;
      color: white;
      position: relative;
    }

    .rotating-text p {
      display: inline-flex;
      margin: 0;
      vertical-align: top;
    }

    .word {
      position: absolute;
      display: flex;
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .letter {
      display: inline-block;
      transform-origin: center center 25px;
      transition: transform 0.32s cubic-bezier(0.6, 0, 0.7, 0.2);
    }

    .letter.out {
      transform: rotateX(90deg);
    }

    .letter.in {
      transform: rotateX(0deg);
    }

    .letter.behind {
      transform: rotateX(-90deg);
    }

    .alizarin { color: var(--primary-blue); }
    .wisteria { color: var(--secondary-blue); }
    .peter-river { color: var(--accent-blue); }
    .emerald { color: var(--tertiary-blue); }
    .sun-flower { color: var(--primary-blue); }
  </style>
</head>
<body>
  <div class="header">
    <h1>Numerical Leitner System</h1>
    <div class="main-wrapper">
      <div class="rotating-text">
        <p>Study</p>
        <p>
          <span class="word alizarin">smarter.</span>
          <span class="word wisteria">faster.</span>
          <span class="word peter-river">efficiently.</span>
          <span class="word emerald">focused.</span>
          <span class="word sun-flower">productively.</span>
        </p>
      </div>
    </div>
  </div>
  <div class="sphere-wrapper">
    <div class="sphere">
      <!-- Sphere Structure will be created dynamically by JavaScript -->
    </div>
  </div>
  <div class="info">
    <p>Preparing the <span>Numerical Leitner System</span> for you...</p>
  </div>
  <div class="footer">
    <p>© 2024 Numerical Leitner System. All rights reserved. <a href="#">Privacy Policy</a></p>
  </div>
  <script>
    const planes = 12;
    const spokes = 36;
    const colors = [
      'var(--primary-blue)',    // Dodger Blue
      'var(--secondary-blue)',  // Steel Blue
      'var(--accent-blue)',     // Deep Sky Blue
      'var(--tertiary-blue)'    // Light Sky Blue
    ];

    for (let i = 1; i <= planes; i++) {
      const plane = document.createElement('div');
      plane.className = `plane plane-${i}`;
      plane.style.transform = `rotateY(${(360 / planes) * i}deg)`;
      
      for (let j = 1; j <= spokes; j++) {
        const spoke = document.createElement('div');
        spoke.className = `spoke spoke-${j}`;
        spoke.style.transform = `rotateZ(${(360 / spokes) * j}deg)`;
        
        const dot = document.createElement('div');
        dot.className = 'dot';
        
        spoke.appendChild(dot);
        plane.appendChild(spoke);
      }

      document.querySelector('.sphere').appendChild(plane);
    }

    for (let i = 0; i <= spokes / 2; i++) {
      const delay = `${i / (spokes / 2)}s`;
      const colorIndex = i % colors.length;

      document.querySelectorAll(`.spoke-${i} .dot, .spoke-${spokes - i} .dot`).forEach(dot => {
        dot.style.animation = `pulsate .6s infinite ${delay} alternate both`;
        dot.style.backgroundColor = colors[colorIndex];
      });
    }

    // Redirect to Add_System.php after a random delay between 2 and 4 seconds
    setTimeout(() => {
      window.location.href = 'welcome.php';
    }, Math.floor(Math.random() * 2000) + 3000); // Random delay between 2000ms (2s) and 4000ms (4s)

    // JavaScript for rotating text animation
    let words = document.querySelectorAll(".word");
    words.forEach(word => {
      let letters = word.textContent.split("");
      word.textContent = "";
      letters.forEach(letter => {
        let span = document.createElement("span");
        span.textContent = letter;
        span.className = "letter";
        word.append(span);
      });
    });

    let currentWordIndex = 0;
    let maxWordIndex = words.length - 1;
    words[currentWordIndex].style.opacity = "1";

    let rotateText = () => {
      let currentWord = words[currentWordIndex];
      let nextWord =
        currentWordIndex === maxWordIndex ? words[0] : words[currentWordIndex + 1];

      // Rotate out letters of current word
      Array.from(currentWord.children).forEach((letter, i) => {
        setTimeout(() => {
          letter.className = "letter out";
        }, i * 80); // Transition speed remains the same
      });

      // Reveal and rotate in letters of next word
      nextWord.style.opacity = "1";
      Array.from(nextWord.children).forEach((letter, i) => {
        letter.className = "letter behind";
        setTimeout(() => {
          letter.className = "letter in";
        }, 340 + i * 80); // Transition speed remains the same
      });

      currentWordIndex = (currentWordIndex === maxWordIndex) ? 0 : currentWordIndex + 1;
    };

    rotateText();
    setInterval(rotateText, 3000); // Reduced interval to show each word for less time
  </script>
</body>
</html>

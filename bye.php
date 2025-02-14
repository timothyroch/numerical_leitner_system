<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Bye</title>
    <style>
        body, html {
            margin: 0;
            background: -webkit-radial-gradient(center, ellipse cover, #111 10%, #333 90%);
            overflow: hidden;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        canvas {
            display: block;
            cursor: crosshair;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        h2 {
            position: absolute;
            bottom: 10px;
            width: 100%;
            letter-spacing: 4px;
            text-align: center;
            font-weight: bold;
            font-size: 1em;
            color: #AAA;
            z-index: 2;
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 15%;
            margin-left: 1%;
            margin-top: 1%;
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
            color: #0078d4;
        }

        .redirect-link {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1em;
            color: #0078d4;
            text-decoration: none;
            z-index: 2;
        }
        
        .redirect-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header"><h1>Numerical Leitner System</h1></div>
    <a href="login.php" class="redirect-link">Go to Login</a>
    <canvas id="canvas"></canvas>
    <h2>Move the mouse!</h2>
    <script>
        const config = {
            text: "Good Bye",
            widthToSpikeLengthRatio: 0.054
        };

        const colorConfig = {
            particleOpacity: 0.2,
            baseHue: 350,
            hueRange: 9,
            hueSpeed: 0.04,
            colorSaturation: 100,
        };

        class Vector {
            constructor(x, y) {
                this.x = x;
                this.y = y;
            }

            add(v) {
                return new Vector(this.x + v.x, this.y + v.y);
            }

            sub(v) {
                return new Vector(this.x - v.x, this.y - v.y);
            }

            getLength() {
                return Math.sqrt(this.x * this.x + this.y * this.y);
            }

            setLength(length) {
                const factor = length / this.getLength();
                this.x *= factor;
                this.y *= factor;
            }

            addTo(v) {
                this.x += v.x;
                this.y += v.y;
            }
        }

        class Planet {
            constructor(x, y, g) {
                this.pos = new Vector(x, y);
                this.g = g;
            }

            draw() {
                ctx.fillStyle = "#AAA";
                ctx.beginPath();
                ctx.arc(this.pos.x, this.pos.y, 8, 0, Math.PI * 2);
                ctx.fill();  
            } 
        }

        class Particle {
            constructor(x, y) {
                this.pos = new Vector(x, y);
                this.vel = new Vector(0, spikeLength);
                this.maxLength = 50;
            }

            move(force) {
                if(force) {
                    this.vel.addTo(force);
                }
                if(this.vel.getLength() > spikeLength) {
                    this.vel.setLength(spikeLength);
                }
            }

            draw() {
                ctx.beginPath();
                ctx.moveTo(this.pos.x, this.pos.y);
                let p2 = this.pos.add(this.vel);
                ctx.lineTo(p2.x, p2.y);
                ctx.stroke();  
            }  
        }

        let canvas;
        let ctx;
        let w, h;
        let hue;
        let particles;
        let spikeLength;
        let planets;
        let A;
        let B;
        let a;
        let b;
        let tick;

        function setup() {
            tick = 0;
            planets = [];
            let len = Math.round(Math.random() * 3 + 3);
            for(let i = 0; i < len; i++) {
                let p = new Planet(50 + i * 100, 340, i ? 1000 : 4000);
                planets.push(p);
            }
            canvas = document.querySelector("#canvas");
            ctx = canvas.getContext("2d");
            window.addEventListener("resize", reset);
            canvas.addEventListener("mousemove", mousemove);
            reset();
        }

        function reset() {
            hue = colorConfig.baseHue; 
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
            spikeLength = w * config.widthToSpikeLengthRatio;
            A = w / 2.2;
            B = h / 2.2;
            a = Math.round(Math.random() + 2);
            b = Math.round(Math.random() + 2);
            drawText();
        }

        function mousemove(event) {
            let x = event.clientX;
            let y = event.clientY;
            planets[0].pos.x = x;
            planets[0].pos.y = y;
        }

        function draw(now) {
            clear();
            requestAnimationFrame(draw);
            updateParticles();
            updatePlanets();
            tick = now / 50;
        }

        function clear() {
            ctx.clearRect(0, 0, w, h);
        }

        function drawText() {
            ctx.save();
            let fontSize = w * 0.2;
            ctx.font = "bold " + fontSize + "px Arial, Helvetica, sans-serif";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            
            // Draw the red outline
            ctx.lineWidth = 5; // Adjust the width of the outline as needed
            ctx.strokeStyle = "red"; // Outline color
            ctx.strokeText(config.text, w / 2, h / 2); // Draw the text outline
            
            // Fill the text with the specified color
            ctx.fillStyle = "white"; // Fill color
            ctx.fillText(config.text, w / 2, h / 2); // Fill the text

            ctx.restore();

            // Capture image data for particles
            let imageData = ctx.getImageData(0, 0, w, h);
            particles = [];

            for (let x = 0; x < w; x += 4) {
                for (let y = 0; y < h; y += 4) {
                    let i = (x + w * y) * 4;
                    let average = (imageData.data[i] + 
                                   imageData.data[i + 1] + 
                                   imageData.data[i + 2] + 
                                   imageData.data[i + 3]) / 4;
                    if (average > 100) { // Adjust this threshold if needed
                        let particle = new Particle(x, y);
                        particles.push(particle);
                    }
                }
            }
            clear();
        }

        function updatePlanets() {
            let len = planets.length;
            for(let i = 1; i < len; i++) {
                let angle = Math.PI * 2 / (len - 1) * i;
                let x = A * Math.sin(a * tick / 100 + angle) + w / 2;
                let y = B * Math.sin(b * tick / 100 + angle) + h / 2; 
                let p = planets[i];
                p.pos.x = x;
                p.pos.y = y;
                p.draw();
            }
        }

        function updateParticles() {
            ctx.strokeStyle = "hsla(210, 100%, 42%, 0.2)"; // Blue color with opacity
            particles.forEach(p => {
                // Apply the force of each planet (repeller) to the current particle
                planets.forEach(planet => {
                    let d = p.pos.sub(planet.pos);
                    let length = d.getLength();
                    let g = planet.g / length;
                    if (g > 30) {
                        g = 20;
                    }
                    // We keep the angle of the distance
                    d.setLength(g);
                    p.move(d);
                });
                p.draw();
            });
        }

        setup();
        draw(1);

        // Redirect to login.php after 7 seconds
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 7000);
    </script>
</body>
</html>

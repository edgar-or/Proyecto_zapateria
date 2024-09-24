const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");
const backgroundMusic = document.getElementById("backgroundMusic");
const eatSound = document.getElementById("eatSound");
const scoreDisplay = document.getElementById("scoreDisplay");

const boxSize = 20;
canvas.width = 400;
canvas.height = 400;

// Variables del juego
let snake = [{ x: boxSize * 5, y: boxSize * 5 }];
let direction = { x: boxSize, y: 0 };
let food = generateFood();
let score = 0;

// Iniciar música
backgroundMusic.play();

// Cambiar dirección con el teclado
document.addEventListener("keydown", (event) => {
    if (event.keyCode === 37 && direction.x === 0) {
        direction = { x: -boxSize, y: 0 };
    } else if (event.keyCode === 38 && direction.y === 0) {
        direction = { x: 0, y: -boxSize };
    } else if (event.keyCode === 39 && direction.x === 0) {
        direction = { x: boxSize, y: 0 };
    } else if (event.keyCode === 40 && direction.y === 0) {
        direction = { x: 0, y: boxSize };
    }
});

// Función para reiniciar el juego
const resetButton = document.getElementById("resetBtn");
resetButton.addEventListener("click", resetGame);

function resetGame() {
    snake = [{ x: boxSize * 5, y: boxSize * 5 }];
    direction = { x: boxSize, y: 0 };
    score = 0;
    scoreDisplay.textContent = score;  // Mostrar puntaje inicial
    food = generateFood(); // Generar comida nueva
    clearInterval(game);
    game = setInterval(gameLoop, 100);
    backgroundMusic.currentTime = 0;
    backgroundMusic.play();
}

// Generar comida en una posición válida
function generateFood() {
    let newFood;
    while (true) {
        newFood = {
            x: Math.floor(Math.random() * (canvas.width / boxSize)) * boxSize,
            y: Math.floor(Math.random() * (canvas.height / boxSize)) * boxSize,
        };
        // Verificar que la comida no esté en la serpiente o en las paredes
        if (!snake.some(segment => segment.x === newFood.x && segment.y === newFood.y) &&
            newFood.x > 0 && newFood.x < canvas.width - boxSize &&
            newFood.y > 0 && newFood.y < canvas.height - boxSize) {
            break;
        }
    }
    return newFood;
}

// Función para cambiar dirección
function changeDirection(dir) {
    if (dir === 'up' && direction.y === 0) {
        direction = { x: 0, y: -boxSize };
    } else if (dir === 'down' && direction.y === 0) {
        direction = { x: 0, y: boxSize };
    } else if (dir === 'left' && direction.x === 0) {
        direction = { x: -boxSize, y: 0 };
    } else if (dir === 'right' && direction.x === 0) {
        direction = { x: boxSize, y: 0 };
    }
}

function update() {
    let newHead = {
        x: snake[0].x + direction.x,
        y: snake[0].y + direction.y,
    };

    if (
        newHead.x < 0 || newHead.x >= canvas.width ||
        newHead.y < 0 || newHead.y >= canvas.height ||
        snake.some((segment) => segment.x === newHead.x && segment.y === newHead.y)
    ) {
        clearInterval(game);
        backgroundMusic.pause();
        alert("Game Over! Buen puntaje :D " + score);
        return;
    }

    snake.unshift(newHead);

    if (newHead.x === food.x && newHead.y === food.y) {
        score++;
        scoreDisplay.textContent = score;  // Actualizar puntaje
        eatSound.play();  // Reproducir sonido al comer
        food = generateFood(); // Generar nueva comida
    } else {
        snake.pop();
    }
}

function draw() {
    ctx.fillStyle = "black"; 
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    snake.forEach((segment) => {
        ctx.fillStyle = "blue";
        ctx.fillRect(segment.x, segment.y, boxSize, boxSize);
    });

    ctx.fillStyle = "red";
    ctx.fillRect(food.x, food.y, boxSize, boxSize);
}

function gameLoop() {
    update();
    draw();
}

let game = setInterval(gameLoop, 100);

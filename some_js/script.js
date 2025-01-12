// PASSENGER COUNTER 

let count = 0;
let countEl = document.getElementById("count-el");
let savedCounts = document.getElementById("saved-counts");
let totalPassengers = 0;
let totalPassengersEl = document.getElementById("total-passengers");

function increment() {
   count += 1;
   countEl.textContent = count;
}

function decrement() {
    if (count > 0) {
        count -= 1;
        countEl.textContent = count;
    }
}

function save(){
    if (savedCounts.textContent !== "") {
        savedCounts.textContent += " - ";
    }
    let countStr = count;
    savedCounts.textContent += countStr;
    totalPassengers += count;
    totalPassengersEl.textContent = totalPassengers;
    count = 0;
    countEl.textContent = count;
}


//PRE-BLACKJACK

let canYouEnter = document.getElementById("canYouEnter")
let ageToCompare = document.getElementById("age")
let buttonContainer = document.getElementById("buttonContainer");
let buttonCreated = false;

function oldEnough() {
    let age = parseInt(ageToCompare.value); 
    if (!isNaN(age) && age > 0 && age <= 120) {
        if (age >= 18) {
            canYouEnter.textContent = "You are old enough to enter the Casino.";
            createButton();
            hideAgeInput();
        } else {
            canYouEnter.textContent = "You are too young to enter the Casino.";
        }
    } else {
        canYouEnter.textContent = "Please enter a valid age between 1 and 120.";
    }
}

function createButton() {
    if (!buttonCreated) {
     let button = document.createElement("button");
   button.textContent = "Enter the Casino";
   button.className = "styled-button";
    button.onclick = function() {
         window.location.href = "casino.html"; 
     };
     buttonContainer.appendChild(button);
     buttonCreated = true;
    }
 }

 function hideAgeInput() {
    ageToCompare.classList.add('hidden');
    document.getElementById("enterAgeButton").classList.add('hidden');
    document.getElementById("ageLabel").classList.add('hidden');
}


// Blackjack

const suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
const ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];

function createDeck() {
  let deck = [];
   for (let suit of suits) {
     for (let rank of ranks) {
     deck.push({ rank, suit }); 
     }
   }
 return deck;
}

function shuffle(deck) {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
       [deck[i], deck[j]] = [deck[j], deck[i]];
    }
    return deck;
}

let deck = shuffle(createDeck());
let hasBlackJack = false;
let gameOn = false;
let cards = [];
let cardSum = 0;

let player = {
    name: "Player",
    money: 200
};

let playerInfo = document.getElementById("player");
playerInfo.textContent = player.name + ": " + player.money + "€";

let message = "Want to play a round?";
let messageoutput = document.getElementById("message");
messageoutput.textContent = message;

let cardoutput = document.querySelector("#cards");
let cardsumoutput = document.querySelector("#cardsum");
cardoutput.textContent = "";
cardsumoutput.textContent = "";

let startbtn = document.getElementById("start-btn");
let newcardbtn = document.getElementById("newcard-btn");
let againbtn = document.getElementById("again-btn");
let resetbtn = document.getElementById("reset-btn");
newcardbtn.classList.add("hidden");
againbtn.classList.add("hidden");
resetbtn.classList.add('hidden');

function startgame() {
 resetbtn.classList.add('hidden');
 newcardbtn.classList.add("hidden");
againbtn.classList.add("hidden");

deck = shuffle(createDeck());
    
let firstCard = drawCard();
let secondCard = drawCard();
cards = [firstCard, secondCard];
cardSum = calculateCardSum(cards);
gameOn = true;

renderGame();
}

function renderGame() {
    cardoutput.textContent = "Cards: ";
    
    const cardContainer = document.getElementById('card-container');
    cardContainer.innerHTML = "";

    for (let card of cards) {
        renderCard(card);
    }

    cardsumoutput.textContent = "Sum: " + cardSum;
    startbtn.classList.add('hidden');


    if (cardSum <= 20) {
        message = ("Draw another card?");
        newcardbtn.classList.remove("hidden");
    } else if (cardSum === 21) {
        message = ("Blackjack! You win!");
        hasBlackJack = true;
        player.money += 50;
        newcardbtn.classList.add("hidden");
        againbtn.classList.remove("hidden");
    } else { 
        message = ("You're out!");
        gameOn = false;
        newcardbtn.classList.add("hidden");
        againbtn.classList.remove("hidden");
        player.money -= 25;
    }

    if (player.money <= 0) {
        newcardbtn.classList.add("hidden");
        startbtn.classList.add("hidden");
        againbtn.classList.add("hidden");
      message = message + (" Game Over! Your money is 0 or below.");
      resetbtn.classList.remove('hidden');
    }

    messageoutput.textContent = message;
    playerInfo.textContent = player.name + ": " + player.money + "€"; 
}

function newcard() {
    let newcard = drawCard();
    cards.push(newcard);
    cardSum = calculateCardSum(cards);
    renderGame();
    renderCard(newcard);
}

function drawCard() {
    return deck.pop(); 
}

function calculateCardSum(cards) {
    let sum = 0;
    for (let card of cards) {
      let value = parseInt(card.rank);
       if (isNaN(value)) { 
         if (['Jack', 'Queen', 'King'].includes(card.rank)) {
             value = 10; 
         } else { //Ace
                value = 11; 
             }
        }
        sum += value;
    }
    return sum;
}

function  resetGame() {
    player.money = 200;
    cards = [];
    cardSum = 0;
    hasBlackJack = false;
    gameOn = false;

    cardoutput.textContent = "";
    cardsumoutput.textContent = "";
    const cardContainer = document.getElementById('card-container');
    cardContainer.innerHTML = "";

    startbtn.classList.remove('hidden');
    newcardbtn.classList.add('hidden');
    againbtn.classList.add('hidden');
    resetbtn.classList.add('hidden');

    message = "Want to play a round?";
    messageoutput.textContent = message;

    playerInfo.textContent = player.name + ": " + player.money + "€";
}



function renderCard(card) {
    const existingCard = document.querySelector(`.card[data-rank="${card.rank}"][data-suit="${card.suit}"]`);

    if (!existingCard) {
        const cardElement = document.createElement('div');
        cardElement.classList.add('card') ;
        cardElement.classList.add(card.suit.toLowerCase());
        cardElement.setAttribute('data-rank', card.rank);
        cardElement.setAttribute('data-suit', card.suit);
        
        switch (card.suit) {
            case 'Hearts': cardElement.classList.add('heart'); break;
            case 'Diamonds': cardElement.classList.add('diamond'); break;
            case 'Clubs': cardElement.classList.add('club'); break;
            case 'Spades': cardElement.classList.add('spade'); break;
            default: break; 
        }
        cardElement.textContent = card.rank;

         document.getElementById('card-container').appendChild(cardElement);
   }
}
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Brackeys_Tutorial
{
    class Program
    {
        static void Main(string[] args)
        {
           //Saatoin vähän sooloilla.
           //Mutta kaiken oleellisen pitäisi olla.
           //Ei pitäisi olla paljon bugejakaan, 
           //mutta en vanno, koska tämä on ensimmäinen tällainen ikinä.
           //ehkä vähän spagetti, mutta ajatus on tärkein,
           //ja se, että yrittää!
           // :) 
           
            Console.Title = "Hero's Journey";
            Console.ForegroundColor = ConsoleColor.White;
            Console.BackgroundColor = ConsoleColor.Black;
            Console.WindowHeight = 40;

            //This keeps the game running until user exits
            bool gameOn = true;
            while (gameOn)
            {


                Console.Write("Hello, What is your name? ");
                string userName = Console.ReadLine();
                Console.Write($"Hello, {userName},\nwhat is your favorite color? ");
                string userColor = Console.ReadLine();
                userColor = userColor.ToLower();
                string dragonColor = "black";
                switch (userColor)
                {
                    case "white": dragonColor = "white"; Console.BackgroundColor = ConsoleColor.White; Console.ForegroundColor = ConsoleColor.Black; ; break;
                    case "red": dragonColor = "red"; Console.ForegroundColor = ConsoleColor.Red; break;
                    case "blue": dragonColor = "blue"; Console.ForegroundColor = ConsoleColor.Blue; break;
                    case "green": dragonColor = "green"; Console.ForegroundColor = ConsoleColor.Green; break;
                    case "yellow": dragonColor = "yellow"; Console.BackgroundColor = ConsoleColor.Black; Console.ForegroundColor = ConsoleColor.Yellow; break;
                    case "pink": dragonColor = "pink"; Console.ForegroundColor = ConsoleColor.Magenta; break;
                    case "black": break;
                    default: Console.WriteLine("Oh, I dont't think I have that color..."); break;
                }

                bool isValidNumber1 = false;
                bool isValidNumber2 = false;
                int number1 = 0;
                int number2 = 0;

                while (!isValidNumber1)
                {
                    Console.Write("Enter a number: ");
                    string userInput1 = Console.ReadLine();
                    isValidNumber1 = int.TryParse(userInput1, out number1);
                    if (!isValidNumber1)
                    {
                        Console.WriteLine("Invalid input! Please only enter numbers.");
                    }
                }
                while (!isValidNumber2)
                {
                    Console.Write("Enter another number: ");
                    string userInput2 = Console.ReadLine();
                    isValidNumber2 = int.TryParse(userInput2, out number2);
                    if (!isValidNumber2)
                    {
                        Console.WriteLine("Invalid input! Please only enter numbers.");
                    }
                }

                string kingdomSize = "medium";
                int sizeVariable = number1 * number2 - number1;
                if (sizeVariable < 5)
                { kingdomSize = "very small"; }
                if (sizeVariable > 5 && sizeVariable < 15)
                { kingdomSize = "small"; }
                if (sizeVariable > 25 && sizeVariable < 35)
                { kingdomSize = "large"; }
                if (sizeVariable > 40)
                { kingdomSize = "very large"; }
                if (sizeVariable > 100)
                { kingdomSize = "colossal"; }

                Console.WriteLine($"Alright so,\nyou are an adventurer," +
                    $" that has been traveling for {number1} years\nin hopes of finding a dragon.\n" +
                    $"You have arrived in a {kingdomSize} kingdom,\nthat has had dragon problems" +
                    $" recently.\nThe dragon has killed approximately {number2} people.\n\n" +
                    $"In the outskirts of the kingdom, you find it, a fierce {dragonColor} dragon!");

                bool userHPZero = false;
                bool dragonHPZero = false;
                bool userFlee = false;
                int userHP = 10;
                int dragonHP = 15;
                int damage = 0;
                Random random = new Random();
                bool userAlive = true;

                while (!userHPZero && !dragonHPZero && !userFlee)
                {
                    Console.WriteLine();
                    Console.WriteLine($"Dragon's HP: {dragonHP}\n{userName}'s HP: {userHP}");
                    Console.WriteLine($"What do you do, {userName}?\nYou can attack the beast or flee.");
                    string userChoice = Console.ReadLine();
                    userChoice = userChoice.ToLower();
                    if (userChoice == "flee")
                    {
                        userFlee = true;
                    }
                    else if (userChoice == "attack")
                    {
                        damage = random.Next(1, 6);
                        Console.WriteLine();
                        Console.WriteLine($"You attack the dragon! you make {damage} damage to it.");
                        dragonHP = dragonHP - damage;
                    }
                    else
                    {
                        Console.WriteLine();
                        Console.WriteLine("You hesitated, so you lost the turn!\n" +
                            "(only enter \"flee\" or \"attack\")");
                    }

                    if (dragonHP <= 0)
                    {
                        dragonHPZero = true;
                    }
                    if (!userFlee && !dragonHPZero)
                    {
                        damage = random.Next(0, 3);
                        Console.WriteLine();
                        Console.WriteLine($"The dragon attacks you! It does {damage} damage to you!");
                        Console.WriteLine();
                        userHP = userHP - damage;
                    }
                    if (userHP <= 0)
                    {
                        userHPZero = true;
                    }

                }
                if (userFlee)
                {
                    Console.WriteLine();
                    Console.WriteLine($"{userName} fled the battle!");

                }
                if (userHPZero)
                {
                    Console.BackgroundColor = ConsoleColor.Red; Console.ForegroundColor = ConsoleColor.Black;
                    Console.WriteLine();
                    Console.WriteLine($"{userName} has perished...\nGame over!");
                    userAlive = false;
                }
                if (dragonHPZero)
                {
                    Console.WriteLine();
                    Console.WriteLine($"{userName} has defeated the dragon!\nCongratulations, you win!");

                }

                while (userAlive)
                {
                    int userMoney = number2;
                    int smallMeal = 5;
                    int mediumMeal = 10;
                    int largeMeal = 20;
                    Console.WriteLine();
                    Console.WriteLine($"Exhausted {userName} makes their way back" +
                        $" to\nthe {kingdomSize} kingdom to find something to eat.\n" +
                        $"They find an inn and ask for something to eat.\n{userName} " +
                        $"reaches in their pocket and finds {userMoney} coins.");
                    Console.WriteLine();
                    if (userMoney >= smallMeal && userMoney < mediumMeal)
                    {
                        userMoney = userMoney - smallMeal;
                        Console.WriteLine($"{userName} is able to buy some bread and" +
                            $" ale, it helps them a bit.");

                    }
                    else if (userMoney >= mediumMeal && userMoney < largeMeal)
                    {
                        userMoney = userMoney - mediumMeal;
                        Console.WriteLine($"{userName} buys a small meal of meat and potatoes " +
                            $"with wine. They feel great after eating.");
                    }
                    else if (userMoney > largeMeal)
                    {
                        userMoney = userMoney - largeMeal;
                        Console.WriteLine($"{userName} buys a lavish meal. After eating they're feeling " +
                            $"very satisfied.");
                    }

                    else
                    {
                        Console.WriteLine($"The money isn't enough, as the small meal " +
                            $"costs {smallMeal} coins, and {userName} can " +
                            $"only get some water.");
                    }

                    Console.WriteLine($"{userName} now has {userMoney} coins.");
                    Console.WriteLine();
                    if (userMoney > 0)
                    {
                        int potionPrice = 5;
                        Console.WriteLine($"They are thinking about how to use the remaining funds." +
                            $"It would cost {potionPrice} coins to buy a potion. \nHow many coins would" +
                            $" that leave for {userName}?");

                        bool validAnswer = false;
                        int userAnswerNum = 0;
                        while (!validAnswer)
                        {
                            string userAnswer = Console.ReadLine();
                            validAnswer = int.TryParse(userAnswer, out userAnswerNum);
                            if (!validAnswer)
                            {
                                Console.WriteLine("Invalid input! Please only enter numbers.");
                            }
                        }
                        int correctAnswer = userMoney - potionPrice;
                        if (userAnswerNum == correctAnswer)
                        {
                            Console.WriteLine($"Yes, that is correct. it would leave\n" +
                                $"{userName} with {correctAnswer} coins.");
                        }
                        else
                        {
                            Console.WriteLine($"No, that's not it. It would leave\n" +
                                $"{userName} with {correctAnswer} coins.");
                        }
                        if (correctAnswer >= 0)
                        {
                            Console.WriteLine($"{userName} can afford it, so they buy the potion.");
                            userMoney = userMoney - potionPrice;
                        }
                        else
                        {
                            Console.WriteLine($"{userName} cannot afford to buy the potion.");
                        }
                        Console.WriteLine($"They now have {userMoney} coins.");
                    }
                    Console.WriteLine();
                    Console.WriteLine($"{userName} finds an old person playing with a dice.\n" +
                        $"They ask {userName} to try guessing their next roll.\n" +
                        $"Guess the roll (1-6): ");

                    bool validAnswerDice = false;
                    int userDiceInput = 0;
                    while (!validAnswerDice)
                    {
                        string userDiceGuess = Console.ReadLine();
                        validAnswerDice = int.TryParse(userDiceGuess, out userDiceInput);
                        if (!validAnswerDice && userDiceInput < 1 && userDiceInput > 6)
                        {
                            Console.WriteLine("Invalid input! Please only enter numbers 1-6.");
                        }
                    }

                    switch (userDiceInput)
                    {
                        case 1: Console.WriteLine("You guess wrong!"); break;
                        case 2: Console.WriteLine("You guess wrong!"); break;
                        case 3: Console.WriteLine("You guess wrong!"); break;
                        case 4: Console.WriteLine("You guess wrong!"); break;
                        case 5:
                            userMoney = userMoney + userMoney; Console.WriteLine($"You guess correctly!\n" +
                          $"The old person is happy and doubles your coins, magically.\n" +
                          $"You now have {userMoney} coins."); ; break;
                        //this is for now always old person's roll
                        //because erm... It has been foretold!
                        //I could also do it with Random dice = new Random() ; dice.Next(1,6)
                        //and compare that number to user number to users input
                        case 6: Console.WriteLine("You guess wrong!"); break;
                        default: Console.WriteLine("You guess wrong!"); break;
                    }
                    Console.WriteLine();
                    if (userMoney > 0)
                    {
                        Console.WriteLine($"{userName} decides it is logical to think about saving at this point," +
                            $" so they head to the bank.\nBank is {kingdomSize}, just like the kingdom it's in." +
                            $"\nThe banker greets {userName} and tells them about the benefits of their saving accounts." +
                            $"\nThe banker then asks, how many years would user like to save their money?");

                        bool validAnswerBank = false;
                        double userBankInput = 0;
                        while (!validAnswerBank || userBankInput <= 0)
                        {
                            string userBank = Console.ReadLine();
                            validAnswerBank = double.TryParse(userBank, out userBankInput);
                            if (!validAnswerBank)
                            {
                                Console.WriteLine("Invalid input! Please only enter numbers.");
                            }
                            else if(userBankInput <= 0)
                            {
                                Console.WriteLine("Invalid input! Number needs to be greater than zero.");
                            }
                        }
                        double userMoneyDouble = Convert.ToDouble(userMoney);
                        double savingamount = Math.Pow(userMoneyDouble, userBankInput);
                        Console.WriteLine($"The banker explains, that {userName}'s {userMoneyDouble} coins" +
                            $"\nwould become {savingamount} coins in {userBankInput} years with the banks" +
                            $" services.\n{userName} thinks, it sounds a bit strange, but leaves it at that.");
                        Console.WriteLine();
                        double[] savingsSum = new double[] { 23, 4.5, 11 };
                        string[] savingsPlace = new string[] { "Rivertown", "Sandcity", "Forest village" };
                        Console.WriteLine($"While in bank, {userName} remembers they have savings in other " +
                            $"banks\nand ask about them. Banker looks through some papers and finds the info:");
                        for (int i = 0; i < savingsSum.Length; i++)
                        {
                            Console.WriteLine($"{savingsSum[i]} coins in bank of {savingsPlace[i]}");
                        }
                    }
                    Console.WriteLine();
                    List<string> dreams = new List<string>();
                    Console.WriteLine($"It has been a tiring day, and {userName} sits down on a bench\n" +
                        $"to think about life.\nThey remember three things they dream about.");
                    Console.Write("Thing one: ");
                    dreams.Add(Console.ReadLine());
                    Console.Write("Thing two: ");
                    dreams.Add(Console.ReadLine());
                    Console.Write("Thing three: ");
                    dreams.Add(Console.ReadLine());
                    Console.WriteLine($"Oh yes, the true joys of living.\nThen again, maybe" +
                        $" we don't really need {dreams[1]}");
                    dreams.RemoveAt(1);
                    Console.WriteLine("Yes, my biggest dreams are:");
                    foreach (string dream in dreams)
                    {
                        Console.WriteLine(dream);
                    }
                    Console.WriteLine();

                    if (userFlee)
                    {
                        Console.WriteLine($"{userName} suddenly feels wind above them.\n" +
                            $"Do you remember the dragon you left alive?\n...\n...\n" +
                            $"The dragon emerges from the sky and eats {userName}.");
                        Console.BackgroundColor = ConsoleColor.Red; Console.ForegroundColor = ConsoleColor.Black;
                        Console.WriteLine("Dang you, consequences of your own actions!");
                        Console.WriteLine($"{userName} has perished...\nGame over!");
                        userAlive = false;
                    }
                    if (!userFlee && dragonHPZero)
                    {
                        Console.WriteLine();
                        Console.WriteLine($"{userName} thinks, it's about time to continue the journey." +
                            $"\nThey hope to find more dragons to slay!\nSuddenly...");
                        Gem newGem = new Gem();
                        newGem.color = dragonColor;
                        newGem.value = number1;
                        newGem.Find();
                        Console.WriteLine($"What a happy end to the journey!" +
                            $"\n{userName} leaves the {kingdomSize} kingdom.");
                        userAlive = false;
                    }
                }
                Console.ForegroundColor = ConsoleColor.White;
                Console.BackgroundColor = ConsoleColor.Black;
                // gameOn loop, asks user if they want to play again.
                Console.WriteLine("\n\nDo you want to play again?");
                bool GameOnAnswerCorrect = false;
                string userGameOn = "";
                while (!GameOnAnswerCorrect)
                {
                    userGameOn = Console.ReadLine();
                   userGameOn=userGameOn.ToLower();
                        if(userGameOn =="yes")
                        {
                         GameOnAnswerCorrect = true;
                        }
                        else if (userGameOn=="no")
                        {
                        GameOnAnswerCorrect = true;
                        gameOn = false;
                        }
                       else
                       {
                        Console.WriteLine("Invalid input! You can only answer \"yes\" or \"no\"");
                       }
                }
                
            }
            
            Console.WriteLine();
            PrintCountdown(1, 10);
            Console.WriteLine("\n-The End-");
            Console.WriteLine("Press any key to exit");
            Console.ReadKey();
        }
        public static void PrintCountdown(int start, int end)
        {
            for (int i = start; i <= end; i++)
            {
                Console.WriteLine(i + "...");
            }
        }

    }
}

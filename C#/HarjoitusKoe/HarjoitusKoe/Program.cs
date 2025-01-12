using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HarjoitusKoe
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.Title = "Tilauslomake";
            Console.BackgroundColor = ConsoleColor.Yellow;
            Console.ForegroundColor = ConsoleColor.DarkRed;
            bool exitProgram = false;
            while (!exitProgram)
            {
                string pizzeria = "Pitsa Peku";
                Pizza newOrder = new Pizza();
                bool userDone = false;
                while (!userDone)
                {
                    Console.Clear();

                    Console.WriteLine($"Olet tilaamassa pizzaa ravintolasta {pizzeria}.");
                    Console.WriteLine("Saatavilla olevat täytteet:");
                    for (int i = 0; i < Topping.ToppingName.Count; i++)
                    {
                        Console.WriteLine($"{i + 1}. {Topping.ToppingName[i]}");
                    }

                    if (newOrder.Toppings.Count > 0)
                    {
                        Console.WriteLine("\nJo valitut täytteet:");
                        foreach (var topping in newOrder.Toppings)
                        {
                            Console.WriteLine($"- {topping.Name}");
                        }

                    }

                    Console.Write("\nSyötä haluamasi täytteen numero\ntai kirjoita \"e\" lopettaaksesi täytteiden lisäys: ");
                    string userInput = Console.ReadLine();
                    if (userInput == "e")
                    {
                        userDone = true;
                    }
                    else if (int.TryParse(userInput, out int index) && index > 0 && index <= Topping.ToppingName.Count)
                    {
                        string toppingName = Topping.ToppingName[index - 1];
                        Topping newTopping = new Topping(toppingName);
                        newOrder.Toppings.Add(newTopping);
                    }
                    else
                    {
                        Console.WriteLine("Virheellinen syöte! Yritä uudelleen.\n(Paina enter jatkaaksesi.)");
                        Console.ReadKey();
                    }

                }
                bool userDone2 = false;
                bool orderDone = false;
                while (!userDone2)
                {
                    Console.Clear();
                    Console.WriteLine("\nPizzaasi on valittu seuraavat täytteet:");
                    foreach (var topping in newOrder.Toppings)
                    {
                        Console.WriteLine($"- {topping.Name}");
                    }
                    decimal totalPrice = newOrder.CalculatePrice();
                    Console.Write($"\nTilaamasi pizzan hinta on {totalPrice} euroa." +
                        $"\nHyväksytäänkö tilaus? (k/e): ");
                    string userInput2 = Console.ReadLine();
                    if (userInput2 == "k")
                    {
                        orderDone = true;
                        userDone2 = true;
                    }
                    else if (userInput2 == "e")
                    {
                        Console.WriteLine("Oletko varma? kirjoita\n" +
                            "\"e\", jos haluat jatkaa tilauksen tekemistä\n" +
                            "kirjoita \"k\", jos haluat peruuttaa tilauksen:");
                        string userInput3 = Console.ReadLine();
                        if (userInput3 == "k")
                        {
                            exitProgram = true;
                            userDone2 = true;
                        }
                        else if (userInput3 != "e")
                        {
                            Console.WriteLine("Virheellinen syöte! Yritä uudelleen.\n(Paina enter jatkaaksesi.)");
                            Console.ReadKey();
                        }

                    }
                    else
                    {
                        Console.WriteLine("Virheellinen syöte! Yritä uudelleen.\n(Paina enter jatkaaksesi.)");
                        Console.ReadKey();
                    }
                }
                if (orderDone)
                {
                    Console.Clear();
                    Console.WriteLine("Tilaus hyväksytty.\nSyötä seuraavaksi osoite, johon pizza toimitetaan:");
                    string userAddress = Console.ReadLine();
                    Console.Clear();
                    Console.WriteLine($"Kiitoksia!\n{pizzeria} toimittaa pizzanne " +
                        $"mahdollisimman pian osoitteeseen:\n\n{userAddress}\n\n" +
                        $"Voitte nyt sulkea sovelluksen.");
                    exitProgram = true;
                }
            }

            Console.WriteLine("\nPaina mitä vain näppäintä sulkeaksesi sovellus.");
            Console.ReadKey();
        }
    }
}

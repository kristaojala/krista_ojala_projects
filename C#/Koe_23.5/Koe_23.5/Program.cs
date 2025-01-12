using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Koe_23._5
{
    class Program
    {
        static void Main(string[] args)
        {

            Console.WriteLine("Syötä puhelinnumerosi kansainvälisessä muodossa:");
            string userPhoneNumber = "";
            bool correctPhoneNumber = false;
            while (!correctPhoneNumber)
            {
                userPhoneNumber = Console.ReadLine();
                if (userPhoneNumber.StartsWith("+358") && userPhoneNumber.Length == 13)  
                {
                    correctPhoneNumber = true;
                }
                else if (userPhoneNumber.Length != 13)
                {
                    Console.WriteLine("Puhelinnumero on väärän mittainen, yritä uudestaan.\n(Numeron pituuden tulee olla 13 merkkiä)");
                }
                else
                {
                    Console.WriteLine("Numero ei ole hyväksyttävässä muodossa, yritä uudestaan.\n(Kansainvälinen numero alkaa +358)");
                }
            }
            Console.WriteLine("Press any key to continue...");
            Console.ReadKey();
            Console.Clear();
            Console.Write("Syötä etunimesi: ");
            string userFirstName = Console.ReadLine();
            Console.Write("Syötä sukunimesi: ");
            string userLastName = Console.ReadLine();
            Console.WriteLine($"Uusi käyttäjätunnuksesi on: {IdGenerator(userFirstName, userLastName)}");

            Console.WriteLine("Press any key to continue...");
            Console.ReadKey();
            Console.Clear();
            int timesUserGaveInput = 0;
            int maxInputJavelinThrow = 3;
            JavelinThrow[] throws = new JavelinThrow[maxInputJavelinThrow]; 
            Console.WriteLine($"Syötät seuraavaksi keihäänheittojen tuloksia. ( max {maxInputJavelinThrow})");

            while (timesUserGaveInput < maxInputJavelinThrow)
            {
                Console.Write("Syötä urheilijan nimi: ");
                string athleteName = Console.ReadLine();
                int athleteID = timesUserGaveInput + 1;
                int userMeters;
                int userCentimeters;
                int athleteMeters = 0;
                int athleteCentimeters = 0;

                bool correctAnswerM = false;
                while (!correctAnswerM)
                {
                    Console.Write("Syötä heiton pituuden metrit: ");
                    string userInputM = Console.ReadLine();

                    if (int.TryParse(userInputM, out userMeters))
                    {

                        correctAnswerM = true;
                        athleteMeters = userMeters;
                    }
                    else
                    {
                        Console.WriteLine("Virheellinen syöte!\n(Syötteen on oltava kokonaisluku.)");
                    }

                }

                bool correctAnswerCM = false;
                while (!correctAnswerCM)
                {
                    Console.Write("Syötä heiton pituuden senttimetrit: ");
                    string userInputCM = Console.ReadLine();
                    if (int.TryParse(userInputCM, out userCentimeters))
                    {
                        athleteCentimeters = userCentimeters;
                        correctAnswerCM = true;
                    }
                    else
                    {
                        Console.WriteLine("Virheellinen syöte!\n(Syötteen on oltava kokonaisluku.)");
                    }
                }

                JavelinThrow newThrow = new JavelinThrow(athleteID, athleteName, athleteMeters, athleteCentimeters);
                throws[timesUserGaveInput] = newThrow;
                timesUserGaveInput++;
            }
            Console.WriteLine("Olet syöttänyt seuraavat heitot:");
            foreach(JavelinThrow javelinthrow in throws)
            {
                Console.WriteLine($"{javelinthrow.Id}. {javelinthrow.AthleteName}: { javelinthrow.Meters} metriä, { javelinthrow.Centimeters} senttimetriä");
            }
            Console.WriteLine("Press any key to continue...");
            Console.ReadKey();
            Console.Clear();

            List<string> products = new List<string> { "Lapio", "Ämpäri","Harava" };
            List<Product> productList = new List<Product>(products.Count);
            for (int i = 0; i < products.Count; i++)
            {
                Console.Write($"Syötä id tuotteelle {products[i]}: ");
                int newID = int.Parse(Console.ReadLine());
                Console.Write($"Syötä hinta tuotteelle {products[i]}: ");
                decimal newPrice = decimal.Parse(Console.ReadLine());
                Product newproduct = new Product(newID,products[i], newPrice);
                productList.Add(newproduct);
                Console.WriteLine();
            }
            
            foreach(Product productInfo in productList)
            {
                Console.WriteLine($"{productInfo.Id}: {productInfo.Name} - {productInfo.Price} euroa.");
                Console.WriteLine($"Tuotteen 20% alennettu hinta on {Product.CalculateDiscountedPrice(productInfo.Price)} euroa.");
            }
            Console.WriteLine("Press any key to continue...");
            Console.ReadKey();
            Console.Clear();
            Console.WriteLine("Press any key to exit...");
            Console.ReadKey();
        }

        public static string IdGenerator(string firstName, string lastName)
        {
            int firstNameWantedLetters = 3;
            int lastNameWantedLetters = 5;
            char[] firstNameArray = firstName.ToCharArray();
            char[] lastNameArray = lastName.ToCharArray();

            if (firstNameArray.Length < firstNameWantedLetters)
            {
                firstNameWantedLetters = firstNameArray.Length;
            }
            if (lastNameArray.Length < lastNameWantedLetters)
            {
                lastNameWantedLetters = lastNameArray.Length;
            }

            char[] newFirstNameArray = new char[firstNameWantedLetters];
            for (int i = 0; i < firstNameWantedLetters; i++)
            {
                newFirstNameArray[i] = firstNameArray[i];
            }

            char[] newLastNameArray = new char[lastNameWantedLetters];
            for (int i = 0; i < lastNameWantedLetters; i++)
            {
                newLastNameArray[i] = lastNameArray[i];
            }

            string finalFirstName = new string(newFirstNameArray);
            string finalLastName = new string(newLastNameArray);
            string newID = finalLastName + finalFirstName;

            return newID;
        }
    }
}

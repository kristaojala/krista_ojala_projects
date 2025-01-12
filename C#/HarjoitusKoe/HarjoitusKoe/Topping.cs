using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HarjoitusKoe
{
    class Topping
    {
        public static List<string> ToppingName { get; } = new List<string>
    {
        "Pepperoni",
        "Herkkusieni",
        "Oliivi",
        "Jauheliha",
        "Tonnikala"
    };

        public string Name { get; }

        public Topping(string name)
        {
            Name = name;
        }
    }
}

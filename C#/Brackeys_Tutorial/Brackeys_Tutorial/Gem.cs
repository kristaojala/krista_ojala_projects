using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Brackeys_Tutorial
{
    class Gem
    {
        public string color;
        public int value;

        public void Find()
        {
            Console.WriteLine($"They find a {color} gem that has value of {value} coins, and put in in their pocket.");
        }
    }
}

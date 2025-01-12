using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HarjoitusKoe
{
    class Pizza
    {
        public List<Topping> Toppings { get; set; }
        public decimal BasePrice { get; set; }

        public Pizza()
        {
            Toppings = new List<Topping>();
            BasePrice = 15;
        }
        public decimal CalculatePrice()
        {

            decimal basePrice = BasePrice;
            int toppings = Toppings.Count;
            decimal extraCost = (toppings > 3 ) ? (toppings - 3) * 1 : 0;
            decimal totalPrice = basePrice + extraCost;
            return totalPrice;
        }
    }
}

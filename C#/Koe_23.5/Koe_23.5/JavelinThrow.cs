using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Koe_23._5
{
    class JavelinThrow
    {
        public int Id;
        public string AthleteName;
        public int Meters;
        public int Centimeters;

        public JavelinThrow(int id, string athleteName, int meters, int centimeters)
        {
            Id = id;
            AthleteName = athleteName;
            Meters = meters;
            Centimeters = centimeters;
        }

    }
}

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Globalization;
using Microsoft.Maui.Controls;   // for IValueConverter
using Microsoft.Maui.Graphics;   // for Color / Colors

namespace SpeakUpApp;

// MUST be public so XAML can create it
public class BoolToColorConverter : IValueConverter
{
    public object? Convert(object? value, Type targetType, object? parameter, CultureInfo culture)
    {
        bool earned = value is bool b && b;
        return earned ? Color.FromArgb("#ff6666") : Colors.LightGray;
    }

    public object? ConvertBack(object? value, Type targetType, object? parameter, CultureInfo culture)
        => throw new NotImplementedException();
}

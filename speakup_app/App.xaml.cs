using SpeakUpApp.Views;

namespace SpeakUpApp;

public partial class App : Application
{
    public App(SplashPage splash)
    {
        InitializeComponent();

        // Navigation stack with Splash first
        MainPage = new NavigationPage(splash)
        {
            BarBackgroundColor = Color.FromArgb("#0077cc"),
            BarTextColor = Colors.White
        };
    }
}

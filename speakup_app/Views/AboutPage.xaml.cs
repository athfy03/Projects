namespace SpeakUpApp.Views;
using System.Linq;

public partial class AboutPage : ContentPage
{
    public AboutPage()
    {
        InitializeComponent();
    }

    private async void Back_Clicked(object sender, EventArgs e)
    {
        await Navigation.PopAsync();
    }
    private async void HomeButton_Clicked(object sender, EventArgs e)
    {
        while (Navigation.NavigationStack.LastOrDefault() is not HomePage
               && Navigation.NavigationStack.Count > 1)
        {
            await Navigation.PopAsync(false);
        }
    }
}

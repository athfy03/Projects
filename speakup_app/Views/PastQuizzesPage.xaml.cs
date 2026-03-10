using SpeakUpApp.Models;
using SpeakUpApp.Services;
using System.Linq;

namespace SpeakUpApp.Views;

public partial class PastQuizzesPage : ContentPage
{
    private readonly FirebaseService _firebase;

    public PastQuizzesPage(FirebaseService firebase)
    {
        InitializeComponent();
        _firebase = firebase;
    }

    protected override async void OnAppearing()
    {
        base.OnAppearing();

        var sessions = await _firebase.GetQuizSessionsAsync();
        SessionsList.ItemsSource = sessions;
    }

    // Called when user taps any past-quiz card
    private async void SessionCard_Tapped(object sender, TappedEventArgs e)
    {
        if (sender is not Frame frame)
            return;

        if (frame.BindingContext is not QuizSession session)
            return;

        await Navigation.PushAsync(new QuizReviewPage(_firebase, session));
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

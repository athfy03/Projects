using SpeakUpApp.Services;

namespace SpeakUpApp.Views;

public partial class SplashPage : ContentPage
{
    private readonly FirebaseService _firebase;

    public SplashPage(FirebaseService firebase)
    {
        InitializeComponent();
        _firebase = firebase;
    }

    protected override async void OnAppearing()
    {
        base.OnAppearing();

        // touch Firebase once (creates user id etc)
        _firebase.GetOrCreateUserId();

        await Task.Delay(2000); // 2 seconds
        await Navigation.PushAsync(
            new HomePage(_firebase));
    }
}

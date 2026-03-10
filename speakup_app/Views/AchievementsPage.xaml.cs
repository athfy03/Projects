using SpeakUpApp.Models;
using SpeakUpApp.Services;
using System.Linq;

namespace SpeakUpApp.Views;

public partial class AchievementsPage : ContentPage
{
    private readonly FirebaseService _firebase;

    public AchievementsPage(FirebaseService firebase)
    {
        InitializeComponent();
        _firebase = firebase;
    }

    protected override async void OnAppearing()
    {
        base.OnAppearing();

        var sessions = await _firebase.GetQuizSessionsAsync();

        int totalSessions = sessions.Count;
        bool hasWordMaster = sessions.Any(s => s.CorrectAnswers >= 4);

        var achievements = new List<Achievement>
        {
            new Achievement
            {
                Title = "7-DAY STREAK",
                Description = "Complete 7 quiz sessions.",
                IsEarned = totalSessions >= 7,
                BadgeImage = "streak_badge.png"
            },
            new Achievement
            {
                Title = "WORD MASTER",
                Description = "Score 4 or more in one session.",
                IsEarned = hasWordMaster,
                BadgeImage = "wordmaster_badge.png"
            }
        };

        AchievementsList.ItemsSource = achievements;
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

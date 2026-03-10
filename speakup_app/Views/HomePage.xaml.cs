using SpeakUpApp.Services;

namespace SpeakUpApp.Views;

public partial class HomePage : ContentPage
{
    private readonly FirebaseService _firebase;

    public HomePage(FirebaseService firebase)
    {
        InitializeComponent();
        _firebase = firebase;
        UpdateLevelLabel();          // <-- runs when a *new* HomePage is created
    }

    protected override void OnAppearing()
    {
        base.OnAppearing();
        UpdateLevelLabel();          // <-- runs whenever you *return* to Home
    }

    private async void UpdateLevelLabel()
    {
        var sessions = await _firebase.GetQuizSessionsAsync();

        if (sessions == null || sessions.Count == 0)
        {
            LevelLabel.Text = "Level 1 • 0/100 XP";
            return;
        }

        int totalXp = 0;

        foreach (var session in sessions)
        {
            totalXp += session.CorrectAnswers * 10;

            if (session.TotalQuestions > 0)
            {
                double percentage = (double)session.CorrectAnswers / session.TotalQuestions;
                if (percentage >= 0.6)
                    totalXp += 10;
            }
        }

        const int xpPerLevel = 100;
        int level = (totalXp / xpPerLevel) + 1;
        int xpIntoLevel = totalXp % xpPerLevel;

        LevelLabel.Text = $"Level {level} • {xpIntoLevel}/{xpPerLevel} XP";
    }


    private async void StartQuiz_Clicked(object sender, EventArgs e)
    {
        await Navigation.PushAsync(new QuizPage(_firebase));
    }

    private async void ReviewAnswers_Clicked(object sender, EventArgs e)
    {
        await Navigation.PushAsync(new PastQuizzesPage(_firebase));
    }

    private async void Achievements_Clicked(object sender, EventArgs e)
    {
        await Navigation.PushAsync(new AchievementsPage(_firebase));
    }

    private async void AboutUs_Clicked(object sender, EventArgs e)
    {
        await Navigation.PushAsync(new AboutPage());
    }
    private void HomeButton_Clicked(object sender, EventArgs e)
    {
        // Already on Home, so nothing needed.
    }
}

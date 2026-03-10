using SpeakUpApp.Models;
using SpeakUpApp.Services;
using System.Linq;

namespace SpeakUpApp.Views;

public partial class QuizReviewPage : ContentPage
{
    private readonly FirebaseService _firebase;
    private readonly QuizSession _session;

    public QuizReviewPage(FirebaseService firebase, QuizSession session)
    {
        InitializeComponent();
        _firebase = firebase;
        _session = session;
    }

    protected override void OnAppearing()
    {
        base.OnAppearing();

        if (_session.Questions == null || _session.Questions.Count == 0 ||
            _session.SelectedIndexes == null || _session.SelectedIndexes.Count == 0)
        {
            QuestionsList.ItemsSource = new List<QuestionReviewItem>
            {
                new QuestionReviewItem
                {
                    Number = 0,
                    QuestionText = "No detailed answers are available for this session.",
                    SelectedOption = "",
                    CorrectOption = "",
                    IsCorrect = false
                }
            };
            return;
        }

        var items = new List<QuestionReviewItem>();

        for (int i = 0; i < _session.Questions.Count; i++)
        {
            var q = _session.Questions[i];
            int selectedIndex = i < _session.SelectedIndexes.Count ? _session.SelectedIndexes[i] : -1;

            string selectedText = selectedIndex >= 0 && selectedIndex < q.Options.Count
                ? q.Options[selectedIndex]
                : "No answer selected";

            string correctText = (q.CorrectIndex >= 0 && q.CorrectIndex < q.Options.Count)
                ? q.Options[q.CorrectIndex]
                : "";

            items.Add(new QuestionReviewItem
            {
                Number = i + 1,
                QuestionText = q.QuestionText,
                SelectedOption = selectedText,
                CorrectOption = correctText,
                IsCorrect = selectedIndex == q.CorrectIndex
            });
        }

        QuestionsList.ItemsSource = items;
    }

    private async void Back_Clicked(object sender, EventArgs e)
    {
        await Navigation.PopAsync();
    }

    // HOME BUTTON – always go straight to Home
    private void HomeButton_Clicked(object sender, EventArgs e)
    {
        Application.Current!.MainPage = new NavigationPage(new HomePage(_firebase))
        {
            BarBackgroundColor = Color.FromArgb("#0077cc"),
            BarTextColor = Colors.White
        };
    }
}

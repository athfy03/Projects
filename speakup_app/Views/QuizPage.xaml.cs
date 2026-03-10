using SpeakUpApp.Models;
using SpeakUpApp.Services;
using System.Linq;


namespace SpeakUpApp.Views;

public partial class QuizPage : ContentPage
{
    private readonly FirebaseService _firebase;
    private readonly List<QuizQuestion> _questions;
    private readonly List<int> _selectedIndexes;
    private int _currentIndex = 0;

    public QuizPage(FirebaseService firebase)
    {
        InitializeComponent();
        _firebase = firebase;

        _questions = BuildQuestions();
        _selectedIndexes = Enumerable.Repeat(-1, _questions.Count).ToList();

        ShowCurrentQuestion();
    }

    private List<QuizQuestion> BuildQuestions()
    {
        // ------- SET 1 -------
        var set1 = new List<QuizQuestion>
    {
        new()
        {
            QuestionText = "What does 'elated' mean?",
            Options = new() { "Sad", "Very happy", "Angry", "Confused" },
            CorrectIndex = 1
        },
        new()
        {
            QuestionText = "Choose the best synonym for 'rapid'.",
            Options = new() { "Slow", "Loud", "Fast", "Bright" },
            CorrectIndex = 2
        },
        new()
        {
            QuestionText = "Which word means the opposite of 'difficult'?",
            Options = new() { "Easy", "Hard", "Strange", "Sharp" },
            CorrectIndex = 0
        },
        new()
        {
            QuestionText = "What does 'reliable' mean?",
            Options = new() { "Can be trusted", "Always late", "Very noisy", "Not interested" },
            CorrectIndex = 0
        },
        new()
        {
            QuestionText = "Which sentence uses 'their' correctly?",
            Options = new()
            {
                "There going to the park.",
                "Their going to the park.",
                "They’re dog lost it’s ball.",
                "Their dog lost its ball."
            },
            CorrectIndex = 3
        }
    };

        // ------- SET 2 -------
        var set2 = new List<QuizQuestion>
    {
        new()
        {
            QuestionText = "What does 'brief' mean?",
            Options = new() { "Long", "Short", "Loud", "Deep" },
            CorrectIndex = 1
        },
        new()
        {
            QuestionText = "Choose the best synonym for 'assist'.",
            Options = new() { "Help", "Hide", "Argue", "Ignore" },
            CorrectIndex = 0
        },
        new()
        {
            QuestionText = "Which word means 'very tired'?",
            Options = new() { "Energetic", "Exhausted", "Excited", "Relaxed" },
            CorrectIndex = 1
        },
        new()
        {
            QuestionText = "What does 'polite' mean?",
            Options = new() { "Rude", "Kind and respectful", "Silent", "Lazy" },
            CorrectIndex = 1
        },
        new()
        {
            QuestionText = "Choose the correct spelling:",
            Options = new() { "Definate", "Defenite", "Definite", "Deffinite" },
            CorrectIndex = 2
        }
    };

        // ------- SET 3 -------
        var set3 = new List<QuizQuestion>
    {
        new()
        {
            QuestionText = "What does 'optional' mean?",
            Options = new() { "Required", "Not necessary", "Dangerous", "Wrong" },
            CorrectIndex = 1
        },
        new()
        {
            QuestionText = "Choose the best antonym for 'increase'.",
            Options = new() { "Grow", "Rise", "Reduce", "Add" },
            CorrectIndex = 2
        },
        new()
        {
            QuestionText = "Which word means 'able to change easily'?",
            Options = new() { "Flexible", "Broken", "Silent", "Empty" },
            CorrectIndex = 0
        },
        new()
        {
            QuestionText = "What does 'rarely' mean?",
            Options = new() { "Very often", "Sometimes", "Hardly ever", "Always" },
            CorrectIndex = 2
        },
        new()
        {
            QuestionText = "Which sentence is correct?",
            Options = new()
            {
                "She don’t like coffee.",
                "She doesn’t like coffee.",
                "She not like coffee.",
                "She isn’t like coffee."
            },
            CorrectIndex = 1
        }
    };

        var allSets = new List<List<QuizQuestion>> { set1, set2, set3 };

        // Pick set based on day of year (rotates over the sets)
        int index = DateTime.Now.Date.DayOfYear % allSets.Count;

        return allSets[index];
    }


    private void ShowCurrentQuestion()
    {
        var q = _questions[_currentIndex];

        QuestionLabel.Text = $"{_currentIndex + 1}. {q.QuestionText}";
        OptionA.Content = $"a. {q.Options[0]}";
        OptionB.Content = $"b. {q.Options[1]}";
        OptionC.Content = $"c. {q.Options[2]}";
        OptionD.Content = $"d. {q.Options[3]}";

        // clear & re-check selected option
        OptionA.IsChecked = OptionB.IsChecked = OptionC.IsChecked = OptionD.IsChecked = false;
        int sel = _selectedIndexes[_currentIndex];

        if (sel == 0) OptionA.IsChecked = true;
        else if (sel == 1) OptionB.IsChecked = true;
        else if (sel == 2) OptionC.IsChecked = true;
        else if (sel == 3) OptionD.IsChecked = true;

        ProgressLabel.Text = $"Question {_currentIndex + 1} of {_questions.Count}";

        NextButton.Text = _currentIndex == _questions.Count - 1 ? "Finish" : "Next";
    }

    private void Option_CheckedChanged(object sender, CheckedChangedEventArgs e)
    {
        if (!e.Value) return;

        int index = (sender == OptionA) ? 0 :
                    (sender == OptionB) ? 1 :
                    (sender == OptionC) ? 2 : 3;

        _selectedIndexes[_currentIndex] = index;
    }

    private void Prev_Clicked(object sender, EventArgs e)
    {
        if (_currentIndex > 0)
        {
            _currentIndex--;
            ShowCurrentQuestion();
        }
    }

    private async void Next_Clicked(object sender, EventArgs e)
    {
        if (_currentIndex < _questions.Count - 1)
        {
            _currentIndex++;
            ShowCurrentQuestion();
        }
        else
        {
            await FinishQuizAsync();
        }
    }

    private async Task FinishQuizAsync()
    {
        int correct = 0;
        for (int i = 0; i < _questions.Count; i++)
        {
            if (_selectedIndexes[i] == _questions[i].CorrectIndex)
                correct++;
        }

        var session = new QuizSession
        {
            Date = DateTime.UtcNow,
            TotalQuestions = _questions.Count,
            CorrectAnswers = correct,
            SelectedIndexes = _selectedIndexes.ToList(),
            Questions = _questions  // NEW: store full question set
        };


        await _firebase.SaveQuizSessionAsync(session);

        await DisplayAlert("Quiz Finished",
            $"You scored {correct} out of {_questions.Count}.",
            "OK");

        await Navigation.PopAsync(); // back to home
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

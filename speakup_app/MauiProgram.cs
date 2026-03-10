using Microsoft.Extensions.Logging;
using SpeakUpApp.Services;

namespace SpeakUpApp;

public static class MauiProgram
{
    public static MauiApp CreateMauiApp()
    {
        var builder = MauiApp.CreateBuilder();
        builder
            .UseMauiApp<App>()
            .ConfigureFonts(fonts =>
            {
                fonts.AddFont("OpenSans-Regular.ttf", "OpenSansRegular");
                fonts.AddFont("OpenSans-Semibold.ttf", "OpenSansSemibold");
            });

        // Register FirebaseService for DI
        builder.Services.AddSingleton<FirebaseService>();

        // Register pages so we can resolve them with DI
        builder.Services.AddTransient<Views.SplashPage>();
        builder.Services.AddTransient<Views.HomePage>();
        builder.Services.AddTransient<Views.QuizPage>();
        builder.Services.AddTransient<Views.AchievementsPage>();
        builder.Services.AddTransient<Views.PastQuizzesPage>();
        builder.Services.AddTransient<Views.AboutPage>();
        builder.Services.AddTransient<Views.QuizReviewPage>();

        return builder.Build();
    }
}


using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Net.Http;
using System.Text;
using System.Text.Json;
using SpeakUpApp.Models;

namespace SpeakUpApp.Services
{
    public class FirebaseService
    {
        private readonly HttpClient _httpClient;

        // TODO: change this to YOUR database URL
        private const string BaseUrl = "https://speakup-app-75921-default-rtdb.asia-southeast1.firebasedatabase.app/";

        public FirebaseService()
        {
            _httpClient = new HttpClient();
        }

        // simple device-based user id (no auth)
        public string GetOrCreateUserId()
        {
            const string key = "speakup_user_id";
            if (Preferences.ContainsKey(key))
                return Preferences.Get(key, "");

            var id = Guid.NewGuid().ToString();
            Preferences.Set(key, id);
            return id;
        }

        // Save a quiz session (answers + score)
        public async Task SaveQuizSessionAsync(QuizSession session)
        {
            string userId = GetOrCreateUserId();

            string json = JsonSerializer.Serialize(session);
            var content = new StringContent(json, Encoding.UTF8, "application/json");

            // POST to /users/{userId}/sessions
            var response = await _httpClient.PostAsync(
                $"{BaseUrl}users/{userId}/sessions.json",
                content);

            response.EnsureSuccessStatusCode();
        }

        // Get all past sessions for list on "Past Quizzes" page
        public async Task<List<QuizSession>> GetQuizSessionsAsync()
        {
            string userId = GetOrCreateUserId();

            var response = await _httpClient.GetAsync(
                $"{BaseUrl}users/{userId}/sessions.json");

            if (!response.IsSuccessStatusCode)
                return new List<QuizSession>();

            var json = await response.Content.ReadAsStringAsync();

            if (string.IsNullOrWhiteSpace(json) || json == "null")
                return new List<QuizSession>();

            var dict = JsonSerializer.Deserialize<Dictionary<string, QuizSession>>(json)
                       ?? new();

            return dict.Values
                .OrderByDescending(s => s.Date)
                .ToList();
        }

        // Very simple achievements: based on number of sessions
        public async Task<List<Achievement>> GetAchievementsAsync()
        {
            var sessions = await GetQuizSessionsAsync();
            int totalSessions = sessions.Count;

            var achievements = new List<Achievement>
            {
                new()
                {
                    Id = "streak7",
                    Title = "7-DAY STREAK",
                    Description = "Complete 7 quiz sessions.",
                    Earned = totalSessions >= 7
                },
                new()
                {
                    Id = "wordmaster",
                    Title = "WORD MASTER",
                    Description = "Score 4 or more in one session.",
                    Earned = sessions.Any(s => s.CorrectAnswers >= 4)
                }
            };

            return achievements;
        }
    }
}

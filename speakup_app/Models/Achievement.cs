namespace SpeakUpApp.Models
{
    public class Achievement
    {
        // Used by FirebaseService and to identify each badge
        public string Id { get; set; } = string.Empty;

        public string Title { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;

        // Main flag the UI uses
        public bool IsEarned { get; set; }

        // Backwards-compatible property for existing code (FirebaseService)
        public bool Earned
        {
            get => IsEarned;
            set => IsEarned = value;
        }

        // Image file in Resources/Images (e.g. "streak_badge.png")
        public string BadgeImage { get; set; } = string.Empty;
    }
}

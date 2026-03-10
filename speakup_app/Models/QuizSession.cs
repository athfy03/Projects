using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SpeakUpApp.Models
{
    public class QuizSession
    {
        public string Id { get; set; } = Guid.NewGuid().ToString();
        public DateTime Date { get; set; } = DateTime.UtcNow;
        public int TotalQuestions { get; set; }
        public int CorrectAnswers { get; set; }
        public List<int> SelectedIndexes { get; set; } = new();

        // NEW: store the full questions for review
        public List<QuizQuestion> Questions { get; set; } = new();
    }
}

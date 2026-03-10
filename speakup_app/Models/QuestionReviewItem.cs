using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SpeakUpApp.Models
{
    public class QuestionReviewItem
    {
        public int Number { get; set; }
        public string QuestionText { get; set; } = string.Empty;
        public string SelectedOption { get; set; } = string.Empty;
        public string CorrectOption { get; set; } = string.Empty;
        public bool IsCorrect { get; set; }
    }
}


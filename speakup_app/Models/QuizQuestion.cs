using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SpeakUpApp.Models
{
    public class QuizQuestion
    {
        public string Id { get; set; } = Guid.NewGuid().ToString();
        public string QuestionText { get; set; } = string.Empty;
        public List<string> Options { get; set; } = new();
        public int CorrectIndex { get; set; }
    }
}

package controller;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ViewResult;

class QuestionController extends Controller
{
	public function list()
	{
		return "List all questions.";
	}
	
	public function view(name:String)
	{
		return "View a specific question: " + name;
	}
	
	public function answer(name:String)
	{
		return "Answer a specific question: " + name;
	}
	
	public function viewanswer(questionname:String, answernumber:String)
	{
		return "View a specific question/answer combo. Q: " + questionname + ", with A: " + answernumber;
	}
	
	public function voteup(questionname:String, answernumber:String)
	{
		return "Vote up answer " + answernumber + " on question " + questionname;
	}
	
	public function votedown(questionname:String, answernumber:String)
	{
		return "Vote down answer " + answernumber + " on question " + questionname;
	}
	
	public function ask()
	{
		return "Allow the user to ask a question";
	}
	
	
}
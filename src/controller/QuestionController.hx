package controller;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ViewResult;

class QuestionController extends Controller
{
	public function list()
	{
		var questionList = model.Question.manager.all();
		return new ViewResult( { 
			questions : questionList
		});
	}
	
	public function view(name:String)
	{
		var question = model.Question.manager.select($slug == name);
		return new ViewResult( { 
			question : question
		});
	}
	
	public function answer(name:String)
	{
		return "Answer a specific question: " + name;
	}
	
	public function viewanswer(questionname:String, answerid:Int)
	{
		var answer = model.Answer.manager.get(answerid);
		return new ViewResult( { 
			answer : answer,
			question : answer.question
		});
	}
	
	public function voteup(questionname:String, answerid:Int)
	{
		return "Vote up answer " + answerid + " on question " + questionname;
	}
	
	public function votedown(questionname:String, answerid:Int)
	{
		return "Vote down answer " + answerid + " on question " + questionname;
	}
	
	public function ask()
	{
		return "Allow the user to ask a question";
	}
	
	
}
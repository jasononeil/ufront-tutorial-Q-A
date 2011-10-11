package controller;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ViewResult;
import AppConfig;

class InstallationController extends Controller
{
	public function information()
	{
		return "<h1>Do you want to install?</h1><pre>"
		+ "\n Server: " + AppConfig.dbServer
		+ "\n Port: " + AppConfig.dbPort
		+ "\n Database: " + AppConfig.dbDatabase
		+ "\n Username: " + AppConfig.dbUser
		+ "\n Password: " + AppConfig.dbPass
		+ "</pre><p>"
		+ "If so, click here: <a href='/install/createtables/'>Install</a>"
		+ "</p>";
	}
	
	public function createtables()
	{
		// Import all the models
		thx.util.Imports.pack("model");
		
		// THESE AREN'T IMPLEMENTED IN THE VERSION OF HAXE I'M RUNNING...
		sys.db.TableCreate.create(model.User.manager);
		sys.db.TableCreate.create(model.Question.manager);
		sys.db.TableCreate.create(model.Answer.manager);
		sys.db.TableCreate.create(model.Vote.manager);
		
		return "<h1>Installed the tables.</h1>"
		+ "<p>You can also <a href='/install/sampledata/'>Install Sample Data</a></p>"
		+ "<p><a href='/'>Or go to the app!</a></p>";
	}
	
	public function sampledata()
	{
		// Check it is empty
		if (model.User.manager.count(true) == 0)
		{
			// create a few users...
			for (name in ['jason', 'billy', 'jill'])
			{
				var u = new model.User();
				u.username = name;
				u.password = "password";
				u.email = name + "@example.com";
				u.registrationDate = Date.now();
				u.insert();
			}
			
			// Insert a first question
			var q1 = new model.Question();
			q1.answered = false;
			q1.date = Date.now();
			q1.title = "Why am I hungry?";
			q1.text = "I'm not usually this hungry.  It's 3:30pm and I haven't had lunch, but still!";
			q1.user = model.User.manager.select($username == "jason");
			q1.insert();
			
			// Insert a second question
			var q2 = new model.Question();
			q2.answered = false;
			q2.date = Date.now();
			q2.title = "Has anyone seen my keys?";
			q2.text = "I could have sworn I left them in the kitchen, but they're not there!  Please help.";
			q2.user = model.User.manager.select($username == "jill");
			q2.insert();
			
			// Insert two answers to the first question
			var a1 = new model.Answer();
			a1.text = "Please RTFM: http://en.wikipedia.org/wiki/Hunger";
			a1.date = Date.now();
			a1.question = q1;
			a1.user = model.User.manager.select($username == "jill");
			a1.insert();
			
			var a2 = new model.Answer();
			a2.text = 
"Good question!  

I personally advocate keeping the fridge next to my desk, so that I can always be close to the food I need.  That way I don't get hungry even if I don't have time to take a lunch break.

Hope that helps!
Billy";
			a2.date = Date.now();
			a2.question = q1;
			a2.user = model.User.manager.select($username == "billy");
			a2.insert();
			
			// Insert votes for the 2 answers
			var v1 = new model.Vote();
			v1.answer = a2;
			v1.user = model.User.manager.select($username == "jason");
			v1.voteUp();
			v1.insert();
			
			var v2 = new model.Vote();
			v2.answer = a2;
			v2.user = model.User.manager.select($username == "jill");
			v2.voteUp();
			v2.insert();
			
			var v3 = new model.Vote();
			v3.answer = a1;
			v3.user = model.User.manager.select($username == "billy");
			v3.voteDown();
			v3.insert();
			
			
			
			return "<h1>Sample data installed.</h1>"
			+ "<p><a href='/'>Go to the app!</a></p>";
		}
		else
		{
			return "<h1>No sample data installed - data already existed!</h1>"
			+ "<p><a href='/'>Go to the app!</a></p>";
		}
		
		 
	}
}
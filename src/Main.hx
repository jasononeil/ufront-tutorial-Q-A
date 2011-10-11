import ufront.web.mvc.MvcApplication;
import ufront.web.AppConfiguration;
import ufront.web.routing.RouteCollection;
import thx.util.Imports;
import AppConfig;

class Main 
{
	static function main() 
	{
		// this line uses Macros to import all classes in the "controller" package
		// you can import controllers one by one if you prefer using "import controller.Home;"
		Imports.pack("controller"); 
		
		// Connect to the database
		connectToDB();
		
		// AppConfiguration takes the arguments (controllerPackage:String, modRewrite:Bool, basePath:String)
		// The values I have here assume you have a package called "controllers", that you have modRewrite enabled,
		// and that all urls from "/" point back to this script by default.
		var config = new AppConfiguration("controller", true, "/");
		
		// regiser routes
		// These methods chain together.  New lines have been added so it's easier to read, but essentially this just
		// keeps going till it gets to the semi-colon.
		//
		// Each addRoute() command asks for the URL to listen to, (with possible variables in {pointy} {brackets}),
		// and then uses an anonymous object to define which controller (class), and which action (method of that controller)
		// to use when dealing with the specified URL.
		// Please note, the {route} {segments} seem to only work as lower case.  Therefore the variables they pass to in the methods
		// must also be {entirelylowercase}.
		var routes = new RouteCollection()
			.addRoute("/",	{ controller : "question", action : "list" } )
			.addRoute("/q/{name}/", { controller : "question", action : "view" } )
			.addRoute("/q/{name}/answer/", { controller : "question", action : "answer" } )
			.addRoute("/q/{questionname}/{answernumber}/", { controller : "question", action : "viewanswer" } )
			.addRoute("/q/{questionname}/{answernumber}/voteup/", { controller : "question", action : "voteup" } )
			.addRoute("/q/{questionname}/{answernumber}/votedown/", { controller : "question", action : "votedown" } )
			.addRoute("/ask/", { controller : "question", action : "ask" } )
			.addRoute("/install/", { controller : "installation", action : "information" } )
			.addRoute("/install/createtables/", { controller : "installation", action : "createtables" } )
			.addRoute("/install/sampledata/", { controller : "installation", action : "sampledata" } )
		;
		
		// Run the application.  
		// Let it know the AppConfiguration and RouteCollection we're starting with.
		// You can optionally send it a "httpContext" as well, but I don't understand this yet.
		new MvcApplication(config, routes).execute();
	}
	
	static public function connectToDB()
	{
		var cnx = sys.db.Mysql.connect({
		   host : AppConfig.dbServer,
		   port : AppConfig.dbPort,
		   user : AppConfig.dbUser,
		   pass : AppConfig.dbPass,
		   database : AppConfig.dbDatabase,
		   socket : AppConfig.dbSocket,
		});
		sys.db.Manager.cnx = cnx;
	}
}
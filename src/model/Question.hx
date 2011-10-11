package model;
import sys.db.Types;
import model.User;
import model.Answer;
using StringTools;

/** 
Model for our questions.  

Relationships:
 - OneToOne: Question.userID = User.id
 - OneToMany: Answer.questionID = Question.id
*/

// INDEXES (please note, don't use semicolon at end of these lines)
// add basic indexes to search by
@:index(userID)
@:index(date)
@:index(slug)
@:index(answered)

class Question extends sys.db.Object 
{	
	/** The unique ID of this model */
	public var id:SUId;
	
	/** The userID of the user who posted this question */
	@:relation(userID) public var user:User;
	
	/** The title of this question */
	public var title:SString<255>;
	
	/** A slug for the URL, based on the title */
	public var slug:SString<255>;
	
	/** Any extra text content (HTML) to be included in this question.  Can be null. */
	public var text:Null<SSmallText>;
	
	/** The date this question was posted */
	public var date:SDateTime;
	
	/** Is this asker satisfied with the snwer to this question? */
	public var answered:Bool;
	
	/** */
	public function answers():List<Answer>
	{
		// Search the Answer table for Answer.questionID = id, orderBy
		return Answer.manager.search($questionID == id);
	}
	
	public function numberOfAnswers():Int
	{
		return Answer.manager.count($questionID == id);
	}
	
	public override function insert()
	{
		// make lower case, replace ' ' with '-'
		var urlslug = title.toLowerCase().replace(" ","-");
		// delete any non standard characters
		urlslug = ~/[^A-Za-z0-9-]/g.replace(urlslug,"");
		this.slug = urlslug;
		super.insert();
	}
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	public static var manager = new sys.db.Manager<Question>(Question);
}
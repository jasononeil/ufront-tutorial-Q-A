package model;
import sys.db.Types;
import model.User;
import model.Answer;

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
@:index(answered)

class Question extends sys.db.Object 
{	
	/** The unique ID of this model */
	public var id:SUId;
	
	/** The userID of the user who posted this question */
	@:relation(userID) public var user:User;
	
	/** The title of this question */
	public var title:SString<255>;
	
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
		return Answer.manager.search($questionID == id, { orderBy : date });
	}
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	public static var manager = new sys.db.Manager<Question>(Question);
}
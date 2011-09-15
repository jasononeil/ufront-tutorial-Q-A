package model;
import sys.db.Types;
import model.User;

/** 
Model for our answers to questions.  

Relationships:
 - OneToOne: Answer.userID = User.id
 - OneToOne: Answer.questionID = Question.id
 - OneToMany: Votes.answerID = Answer.id
*/
class Answer extends sys.db.Object 
{	
	/** The unique ID of this model */
	public var id:SUId;
	
	/** The userID of the user who gave this answer */
	@:relation(userID) public var user:User;
	
	/** The questionID of the question we're answering */
	@:relation(questionID) public var question:Question;
	
	
	/** Any extra text content (HTML) to be included in this question.  Can be null. */
	public var text:Null<SSmallText>;
	
	/** The date this question was posted */
	public var date:SDateTime;
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	static var manager = new sys.db.Manager<Answer>(Answer);
}
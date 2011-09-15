package model;
import sys.db.Types;
import model.User;
import model.Answer;

/** 
Model for our answers to questions.  

Relationships:
 - OneToOne: Vote.userID = User.id
 - OneToOne: Answer.questionID = Question.id
 - OneToMany: Votes.answerID = Answer.id
*/

class Vote extends sys.db.Object 
{	
	/** The unique ID of this model */
	public var id:SUId;
	
	/** The userID of the user who gave this answer */
	@:relation(userID) public var user:User;
	
	/** The questionID of the question we're answering */
	@:relation(answerID) public var answer:Answer;
	
	/** true=1, vote up.  false=0, vote down */
	public var vote:SBool;
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	static var manager = new sys.db.Manager<Vote>(Vote);
}
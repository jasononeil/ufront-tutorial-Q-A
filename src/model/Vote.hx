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

// INDEXES (please note, don't use semicolon at end of these lines)
// define a UNIQUE index that says only allow one vote per user per answer.
@:index(userID,answerID)

// Basic indexes to search by these fields
@:index(answerID)

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
	
	private function voteUp() { vote = true; }
	private function voteDown() { vote = false; }
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	public static var manager = new sys.db.Manager<Vote>(Vote);
}
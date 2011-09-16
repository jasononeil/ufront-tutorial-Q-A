package model;
import sys.db.Types;
import model.User;
import model.Vote;

/** 
Model for our answers to questions.  

Relationships:
 - OneToOne: Answer.userID = User.id
 - OneToOne: Answer.questionID = Question.id
 - OneToMany: Votes.answerID = Answer.id
*/

// INDEXES (please note, don't use semicolon at end of these lines)
// Basic indexes to search by these fields
@:index(userID)
@:index(questionID)

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
	
	public function countUpVotes():Int
	{
		// Search the Vote table for Vote.answerID = id, vote = true (up)
		return Vote.manager.count($answerID == id && $vote == true);
	}
	
	public function countDownVotes():Int
	{
		// Search the Vote table for Vote.answerID = id, vote = false (down)
		return Vote.manager.count($answerID == id && $vote == false);
	}
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	public static var manager = new sys.db.Manager<Answer>(Answer);
}